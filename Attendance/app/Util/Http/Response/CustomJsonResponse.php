<?php

namespace App\Util\Http\Response;

/**
 * Custom json request factory. Used to standardize HTTP response
 * in our application.
 */
class CustomJsonResponse extends CustomResponse{

    /**
     * See parent class.
     * @override
     */
    public function with($param, $content){
        $this -> response[$param] = $content;
        return $this;
    }

    /**
     * See parent class.
     * @override
     */
    public function get($status_code = null){
        return response() -> json($this -> response, $status_code ?: $this -> status_code);
    }

    /**
     * Adds 'message' parameter.
     * 
     * @param string $message the message content
     * @return object
     */
    public function withMessage($message){
        return $this -> with('message', $message);
    }

    /**
     * Adds 'errors' parameter.
     * 
     * @param mixed $errors the error content
     * @return object
     */
    public function withErrors($errors){
        return $this -> with('errors', $errors);
    }

    /**
     * Adds 'status' parameter.
     * 
     * @param int $status the status content
     * @return object
     */
    public function withStatus($status){
        return $this -> with('status', $status);
    }

    /**
     * Adds 'body' parameter.
     * 
     * @param array $body the body content
     * @return object
     */
    public function withBody($body){
        return $this -> with('body', $body);
    }

    /**
     * Adds success informations to the response with an optional body.
     * 
     * Corresponds to a 201 HTTP response by default.
     * 
     * @param array $body the response's body
     * @return object
     */
    public function success($body = [], $status_code = null){
        $this -> status_code = $status_code ?: self::DEFAULT_SUCCESS_CODE;
        return $this -> withStatus('success') -> withBody($body);
    }

    /**
     * Adds failure informations to the response with an errors field.
     * 
     * Corresponds to a 401 HTTP error by default.
     * 
     * @param mixed $errors the response's errors
     * @return object
     */
    public function failure($errors, $status_code = null){
        $this -> status_code = $status_code ?: self::DEFAULT_ERROR_CODE;
        return $this -> withStatus('failure') -> withErrors($errors);
    }
}
