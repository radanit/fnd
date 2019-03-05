<?php

namespace App\Radan\Traits;

/**
 * This file is part of Radan, 
 *
 * @license MIT
 * @package Radan/Traits
 */

trait RadanResponseCodeTrait
{
    /**
     * HTTP Response codes
     *
     * @return protected properties
     */
    
    /*
     * Standard response for successful HTTP requests     
     */
    protected $httpOk = 200;

    /*
     * The request has been fulfilled, 
     * resulting in the creation of a new resource
     */
    protected $httpCreated = 201;

    /*
     * The request has been accepted for processing, 
     * but the processing has not been completed
     */
    protected $httpAccepted = 202;

    /*
     * The server is a transforming proxy that received a 200 OK from its origin,
     * but is returning a modified version of the origin's response
     */
    protected $httpOkProxy = 203;

    /*
     * The server successfully processed the request and is not returning any content
     */
    protected $httpNoContent= 204;

    /*
     * The server successfully processed the request, 
     * but is not returning any content
     */
    protected $httpResetContent = 205;

    /*
     * The server is delivering only part of the resource
     */
    protected $httpPartialContent = 206;

    /*
     * The server cannot or will not process the request due to an apparent client error
     */
    protected $httpBadRequest = 400;

    /*
     * Similar to 403 Forbidden, but specifically for use when authentication is required 
     * and has failed or has not yet been provided server is delivering only part of the resource
     */
    protected $httpUnauthorize = 401;

    /*
     * he server is delivering only part of the resource
     */
    protected $httpForbidden = 403;

    /*
     * The requested resource could not be found but may be available in the future
     */
    protected $httpNotFound = 404;

    /*
     * A request method is not supported for the requested resource
     */
    protected $httpMethodNotAllowed = 405;

    /*
     * The requested resource is capable of generating only content 
     * not acceptable according to the Accept headers sent in the request
     */
    protected $httpNotAcceptable = 406;

    /*
     * The requested resource is capable of generating only content 
     * not acceptable according to the Accept headers sent in the request
     */
    protected $httpUnprocessableEntity = 422;

    /*
     * A generic error message, given when an unexpected condition 
     * was encountered and no more specific message is suitable
     */
    protected $httpInternalServerError = 500;

    /*
     * The server either does not recognize the request method, 
     * or it lacks the ability to fulfil the request
     */
    protected $httpNotImplemented = 501;

    /*
     * The server was acting as a gateway or proxy and received 
     * an invalid response from the upstream server
     */
    protected $httpBadGatewy = 502;

    /*
     * The server is currently unavailable 
     * (because it is overloaded or down for maintenance)
     */
    protected $httpServiceUnavailable = 503;

    /*
     * The server was acting as a gateway or proxy and did not receive 
     * a timely response from the upstream server
     */
    protected $httpGatewayTimeout = 504;

    /*
     * The server does not support the HTTP protocol version used in the reques
     */
    protected $httpVersionNotSupported = 505;

}
