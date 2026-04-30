<?php

namespace ApiTemplate\Handlers;

class HeaderHttpHandler {
    private array $simple;
    private array $crud;
    private array $headers;

    public function __construct(int $codeHeaders) {
        // Construction of every type of headers
        $this->createOptions();
        // We give a list of headers according to code sent
        switch ($codeHeaders) {
            case 1:
                $this->headers = $this->simple;
                break;

            case 2:
                $this->headers = $this->crud;
                break;

            default:
                $this->headers = $this->simple;
                break;
        }

        foreach ($this->headers as $key => $value) {
            header("$key: $value");
        }
    }

    public function getHeaders() {
        $headers = apache_request_headers();
    
        foreach ($headers as $header => $value) {
            echo "$header: $value <br />\n";
        }
        return json_encode($headers);
    }

    private function createOptions(): int {
        $readonly = array(
                // CORS
                "Access-Control-Allow-Origin" => "*",
                "Access-Control-Allow-Methods" => "GET, HEAD, OPTIONS",
                "Access-Control-Allow-Headers" => "Content-Type, Authorization",

                // Content
                "Content-Type" => "application/json; charset=UTF-8",

                // Security
                "Strict-Transport-Security" => "max-age=31536000; includeSubDomains",
                "X-Content-Type-Options" => "nosniff",
                "X-Frame-Options" => "DENY",
                "Content-Security-Policy" => "default-src 'none'",
                "Referrer-Policy" => "no-referrer",
                "Permissions-Policy" => "geolocation=(), camera=(), microphone=()",

                // Cache & integrity
                "Cache-Control" => "public, max-age=300",
                "ETag" => '"abc123"',
                "Last-Modified" => "Thu, 30 Apr 2026 10:00:00 GMT",
                "Vary" => "Accept-Encoding, Authorization",

                // Rate limiting
                "X-RateLimit-Limit" => "1000",
                "X-RateLimit-Remaining" => "984",
                "X-RateLimit-Reset" => "1714550400",
        );

        $crudHeaders = array(
            
                // CORS
                "Access-Control-Allow-Origin" => "*",
                "Access-Control-Allow-Methods" => "GET, POST, PUT, PATCH, DELETE, HEAD, OPTIONS",
                "Access-Control-Allow-Headers" => "Content-Type, Authorization",

                // Content
                "Content-Type" => "application/json; charset=UTF-8",

                // Security
                "Strict-Transport-Security" => "max-age=31536000; includeSubDomains",
                "X-Content-Type-Options" => "nosniff",
                "X-Frame-Options" => "DENY",
                "Content-Security-Policy" => "default-src 'none'",
                "Referrer-Policy" => "no-referrer",
                "Permissions-Policy" => "geolocation=(), camera=(), microphone=()",

                // Cache & integrity
                "Cache-Control" => "no-store",
                "Vary" => "Accept-Encoding, Authorization",

                // Rate limiting
                "X-RateLimit-Limit" => "1000",
                "X-RateLimit-Remaining" => "984",
                "X-RateLimit-Reset" => "1714550400",
            
        );

        $this->simple = $readonly;
        $this->crud = $crudHeaders;
        return 0; // Send succes code to server
    }

    public function requestValid() : bool {
        return true;
    }
}