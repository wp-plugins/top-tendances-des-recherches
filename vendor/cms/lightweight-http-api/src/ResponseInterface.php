<?php

namespace CMS\API;

interface ResponseInterface extends MessageInterface
{
    const
        VALID_STATUS_CODE = 200,
        ERROR_STATUS_CODE = 500;
    
    const
        JSON_CONTENT_TYPE = 'application/json';
}
