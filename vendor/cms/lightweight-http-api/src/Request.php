<?php

namespace CMS\API;

class Request extends Message implements RequestInterface
{
    public function addAuthorizationHeader($username, $password)
    {
        $this->addHeader('Authorization', sprintf(
            '%s %s',
            $username,
            $password
        ));
        
        return $this;
    }
    
    public function post($url)
    {
        return $this->send($url, RequestInterface::POST_METHOD);
    }
    
    public function get($url)
    {
        return $this->send($url, RequestInterface::GET_METHOD);
    }
    
    /**
     * @return Response
     */
    private function send($url, $method)
    {
        $response = new Response();
        
        // silent the file_get_contents function
        $content = @file_get_contents($url, false, $this->buildContext($method));
        
        if ($content === false) {
            // handle the error (not responding)
            $response->buildFatalError($url);
        } else {
            // API is responding
            $headers = array();
            if (isset($http_response_header)) {
                $headers = $http_response_header;
            }
            $response->build($headers, $content);
        }
        
        return $response;
    }
    
    private function buildContext($method)
    {
        // merge the default http options from the default context with our options
        $options = array_merge_recursive(
            stream_context_get_options(stream_context_get_default()),
            $this->getHttpOptions($method)
        );
        
        // create a new context
        return stream_context_create($options);
    }
    
    private function getHttpOptions($method)
    {
        $httpOptions = array(
            'method'        => $method,
            'timeout'       => RequestInterface::DEFAULT_TIMEOUT,
            // get the real body when API send error message
            'ignore_errors' => true
        );
        
        $headers = $this->getHeaders();
        if (!empty($headers)) {
            $httpOptions['header'] = $headers;
        }
        
        if ($this->getBody() !== null) {
            $content = $this->getBody();
            if (is_array($content)) {
                $content = http_build_query($this->getBody());
            }
            $httpOptions['content'] = $content;
        }
        
        return array(
            'http' => $httpOptions,
        );
    }
}
