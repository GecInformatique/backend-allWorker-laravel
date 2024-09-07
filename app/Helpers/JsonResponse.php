<?php

namespace App\Helpers;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

/**
 * Class JsonResponse
 * Simple response object for Laravue application
 * Response format:
 * {
 *   'success': true|false,
 *   'data': [],
 *   'message': ''
 * }
 *
 * @package Laravue
 */
class JsonResponse implements \JsonSerializable
{
    const STATUS_SUCCESS = true;
    const STATUS_ERROR = false;

    /**
     * Data to be returned
     * @var mixed
     */
    private $data = [];

    /**
     * Error message in case process is not success. This will be a string.
     *
     * @var string
     */
    private $message = '';

    /**
     * @var bool
     */
    private $success = false;

    /**
     * JsonResponse constructor.
     * @param mixed $data
     * @param string $message
     * @param bool $status
     */
    public function __construct($data = [], $message = '', $status = false)
    {
        if ($this->shouldBeJson($data)) {
            $this->data = $data;
        }

        $this->message = $message;
        $this->success = $status;
        //$this->success = !empty($data);
    }


    /**
     * Success with data
     *
     * @param array $data
     */
    public function success($data = [])
    {
        $this->success = true;
        $this->data = $data;
        $this->message = '';
    }


    /**
     * Fail with error message
     * @param string $message
     */
    public function fail($message = '')
    {
        $this->success = false;
        $this->message = $message;
        $this->data = [];
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        return [
            'success' => $this->success,
            'data' => $this->data,
            'message' => $this->message,
        ];

    }


    /**
     * Determine if the given content should be turned into JSON.
     *
     * @param  mixed  $content
     * @return bool
     */
    private function shouldBeJson($content)
    {
        return $content instanceof Arrayable ||
            $content instanceof Jsonable ||
            $content instanceof \ArrayObject ||
            $content instanceof \JsonSerializable ||
            is_array($content);
    }
}
