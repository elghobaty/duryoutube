<?php namespace App\Youtube;

use stdClass;

class YoutubeRequestException extends \Exception
{
    /**
     * @var array
     */
    protected $errors;

    /**
     * @param stdClass $response
     * @return YoutubeRequestException
     */
    public static function FromResponse(stdClass $response)
    {
        $genericMessage = "Error " . $response->error->code . " " . $response->error->message;

        $exception = new YoutubeRequestException($genericMessage, $response->error->code);

        $errors = object_get($response, 'error.errors', []);

        $exception->setErrors($errors);

        return $exception;
    }

    /**
     * @param stdClass[] $errors
     * @return $this
     */
    private function setErrors(array $errors)
    {
        $this->errors = $errors;
        return $this;
    }

    /**
     * @return stdClass[]
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param string $reason
     * @return bool
     */
    public function isBecause($reason)
    {
        return !!array_first($this->errors, function ($error) use ($reason) {
            return $error->reason === $reason;
        });
    }
}
