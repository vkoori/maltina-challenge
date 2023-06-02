<?php

namespace App\Service\Responses\Trait;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait ResponseParser
{
	private function standardResp(
		int $statusCode,
		array|string $message = null,
		array|string|JsonResource|Collection|Model $data = []
	): JsonResponse {
		$failed = $statusCode >= 400 ? true : false;
		$data = $failed ? $data : $this->render($data);

		return new JsonResponse(
			data: [
				'error' => $failed,
				'status' => $statusCode,
				'message' => $message ?? Response::$statusTexts[$statusCode],
				...($failed
					? ['errors' => $data]
					: ['data' => $data['res']]
				),
				...(
					(!$failed && $meta = $data['with'])
					? ['meta' => key($meta) ? $meta : current($meta)]
					: []
				),
				...(
					(!$failed && $additional = $data['additional'])
					? ['additional' => key($additional) ? $additional : current($additional)]
					: []
				)
			],
			status: $statusCode,
			headers: [
				"Content-Type" => "application/json"
			]
		);
	}

	private function render(array|string|JsonResource|Collection|Model $data = []): array
	{
		$with = [];
		$additional = [];
		$res = $data;

		if ($data instanceof JsonResource && $data->resource instanceof LengthAwarePaginator) {
			$res = [
				'paginate' => [
					'currentPage' => $data->resource->currentPage(),
					'lastPage' => $data->resource->lastPage(),
					'total' => $data->resource->total(),
				],
				'data' => $data
			];
		}

		if ($data instanceof JsonResource) {
			$with = $data->with(request());
			$additional = $data->additional;
		}

		if (is_array($data)) {
			foreach ($data as $key => $value) {
				$tmp = $this->render($value);
				if ($tmp['with']) {
					$with[$key] = $tmp['with'];
				}
				if ($tmp['additional']) {
					$additional[$key] = $tmp['additional'];
				}
			}
		}

		return [
			'with' => $with,
			'additional' => $additional,
			'res' => $res,
		];
	}
}
