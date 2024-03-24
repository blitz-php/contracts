<?php

/**
 * This file is part of Blitz PHP framework.
 *
 * (c) 2022 Dimitri Sitchet Tomkeu <devcode.dst@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BlitzPHP\Contracts\Http;

/**
 * Codes HTTP
 *
 * Content from http://en.wikipedia.org/wiki/List_of_HTTP_status_codes
 *
 * @credit https://gist.github.com/henriquemoody/6580488
 */
interface StatusCode
{
    /**
     * Codes non officiels
     */
    public const CHECKPOINT                           = 103;
    public const THIS_IS_FIND                         = 218;  // Apache Web Server
    public const PAGE_EXPIRED                         = 419;  // Laravel Framework
    public const METHOD_FAILURE                       = 420;  // Spring Framework
    public const ENHANCE_YOUR_CALM                    = 420;  // Twitter
    public const LOGIN_TIMEOUT                        = 440;  // IIS
    public const NO_RESPONSE                          = 444;  // Nginx
    public const RETRY_WITH                           = 449;  // IIS
    public const BLOCKED_BY_WINDOWS_PARENTAL_CONTROLS = 450;  // Microsoft
    public const REDIRECT                             = 451;  // IIS
    public const REQUEST_HEADER_TOO_LARGE             = 494;  // Nginx
    public const SSL_CERTIFICATE_ERROR                = 495;  // Nginx
    public const SSL_CERTIFICATE_REQUIRED             = 496;  // Nginx
    public const HTTP_REQUEST_SENT_TO_HTTPS_PORT      = 497;  // Nginx
    public const INVALID_TOKEN                        = 498;  // Esri
    public const CLIENT_CLOSED_REQUEST                = 499;  // Nginx
    public const TOKEN_REQUIRED                       = 499;  // Esri
    public const BANDWIDTH_LIMIT_EXCEEDED             = 509;  // Apache Web Server/cPanel
    public const WEB_SERVER_RETURNED_AN_UNKNOWN_ERROR = 520;  // Cloudflare
    public const WEB_SERVER_IS_DOWN                   = 521;  // Cloudflare
    public const CONNECTION_TIMEDOUT                  = 522;  // Cloudflare
    public const ORIGIN_IS_UNREACHABLE                = 523;  // Cloudflare
    public const A_TIMEOUT_OCCURRED                   = 524;  // Cloudflare
    public const SSL_HANDSHAKE_FAILED                 = 525;  // Cloudflare
    public const INVALID_SSL_CERTIFICATE              = 526;  // Cloudflare
    public const RAILGUN_ERROR                        = 527;  // Cloudflare
    public const SITE_IS_OVERLOADED                   = 529;  // Qualys in the SSLLabs
    public const SITE_IS_FROZEN                       = 530;  // Pantheon web platform
    public const TEMPORARILY_DISABLED                 = 540;  // Pantheon web platform
    public const NETWORK_READ_TIMEOUT_ERROR           = 598;  // Informal convention
    public const NETWORK_CONNECT_TIMEOUT_ERROR        = 599;  // Informal convention

    /**
     * Code officiels
     */
    // Informational 1xx
    public const CONTINUE            = 100;
    public const SWITCHING_PROTOCOLS = 101;
    public const PROCESSING          = 102;
    public const EARLY_HINTS         = 103;

    // Successful 2xx
    public const OK                            = 200;
    public const CREATED                       = 201;
    public const ACCEPTED                      = 202;
    public const NON_AUTHORITATIVE_INFORMATION = 203;  // Since HTTP/1.1
    public const NO_CONTENT                    = 204;
    public const RESET_CONTENT                 = 205;
    public const PARTIAL_CONTENT               = 206;  // RFC 7233
    public const MULTI_STATUS                  = 207;  // WebDAV; RFC 4918
    public const ALREADY_REPORTED              = 208;  // WebDAV; RFC 5842
    public const IM_USED                       = 226;  // RFC 3229

    // Redirection 3xx
    public const MULTIPLE_CHOICES   = 300;
    public const MOVED_PERMANENTLY  = 301;
    public const FOUND              = 302;  // Previously "Moved temporarily"
    public const SEE_OTHER          = 303;  // Since HTTP/1.1
    public const NOT_MODIFIED       = 304;
    public const USE_PROXY          = 305;  // Since HTTP/1.1
    public const SWITCH_PROXY       = 306;
    public const TEMPORARY_REDIRECT = 307;  // Since HTTP/1.1
    public const PERMANENT_REDIRECT = 308;  // RFC 7538

    // Client Errors 4xx
    public const BAD_REQUEST                     = 400;
    public const UNAUTHORIZED                    = 401;  // RFC 7235
    public const PAYMENT_REQUIRED                = 402;
    public const FORBIDDEN                       = 403;
    public const NOT_FOUND                       = 404;
    public const METHOD_NOT_ALLOWED              = 405;
    public const NOT_ACCEPTABLE                  = 406;
    public const PROXY_AUTHENTICATION_REQUIRED   = 407;  // RFC 7235
    public const REQUEST_TIMEOUT                 = 408;
    public const CONFLICT                        = 409;
    public const GONE                            = 410;
    public const LENGTH_REQUIRED                 = 411;
    public const PRECONDITION_FAILED             = 412;  // RFC 7232
    public const PAYLOAD_TOO_LARGE               = 413;
    public const URI_TOO_LONG                    = 414;  // RFC 7231
    public const UNSUPPORTED_MEDIA_TYPE          = 415;  // RFC 7231
    public const RANGE_NOT_SATISFIABLE           = 416;  // RFC 7233
    public const EXPECTATION_FAILED              = 417;
    public const IM_A_TEAPOT                     = 418;  // RFC 2324, RFC 7233
    public const MISDIRECTED_REQUEST             = 421;  // RFC 7540
    public const UNPROCESSABLE_ENTITY            = 422;  // WebDAV; RFC 4918
    public const LOCKED                          = 423;  // WebDAV; RFC 4918
    public const FAILED_DEPENDENCY               = 424;  // WebDAV; RFC 4918
    public const TOO_EARLY                       = 425;  // RFC 8470
    public const UPGRADE_REQUIRED                = 426;
    public const PRECONDITION_REQUIRED           = 428;  // RFC 6585
    public const TOO_MANY_REQUESTS               = 429;  // RFC 6585
    public const REQUEST_HEADER_FIELDS_TOO_LARGE = 431;  // RFC 6585
    public const UNAVAILABLE_FOR_LEGAL_REASONS   = 451;  // RFC 7725

    // Server Errors 5xx
    public const INTERNAL_ERROR                  = 500;
    public const NOT_IMPLEMENTED                 = 501;
    public const BAD_GATEWAY                     = 502;
    public const SERVICE_UNAVAILABLE             = 503;
    public const GATEWAY_TIMEOUT                 = 504;
    public const HTTP_VERSION_NOT_SUPPORTED      = 505;
    public const VARIANT_ALSO_NEGOTIATES         = 506;  // RFC 2295
    public const INSUFFICIENT_STORAGE            = 507;  // WebDAV; RFC 4918
    public const LOOP_DETECTED                   = 508;  // WebDAV; RFC 4918
    public const NOT_EXTENDED                    = 510;  // RFC 2774
    public const NETWORK_AUTHENTICATION_REQUIRED = 511;  // RFC 6585

	/**
     * Codes d'état HTTP autorisés et leur description par défaut.
     *
     * @var array<int, string>
     */
	public const VALID_CODES = [
        // 1xx: Informational
        self::CONTINUE            => 'Continue',
        self::SWITCHING_PROTOCOLS => 'Switching Protocols',
        self::PROCESSING          => 'Processing',            // http://www.iana.org/go/rfc2518
        self::EARLY_HINTS         => 'Early Hints',           // http://www.ietf.org/rfc/rfc8297.txt
        // 2xx: Success
        self::OK                            => 'OK',
        self::CREATED                       => 'Created',
        self::ACCEPTED                      => 'Accepted',
        self::NON_AUTHORITATIVE_INFORMATION => 'Non-Authoritative Information',   // 1.1
        self::NO_CONTENT                    => 'No Content',
        self::RESET_CONTENT                 => 'Reset Content',
        self::PARTIAL_CONTENT               => 'Partial Content',
        self::MULTI_STATUS                  => 'Multi-Status',                    // http://www.iana.org/go/rfc4918
        self::ALREADY_REPORTED              => 'Already Reported',                // http://www.iana.org/go/rfc5842
        self::IM_USED                       => 'IM Used',                         // 1.1; http://www.ietf.org/rfc/rfc3229.txt
        // 3xx: Redirection
        self::MULTIPLE_CHOICES   => 'Multiple Choices',
        self::MOVED_PERMANENTLY  => 'Moved Permanently',
        self::FOUND              => 'Found',                // Formerly 'Moved Temporarily'
        self::SEE_OTHER          => 'See Other',            // 1.1
        self::NOT_MODIFIED       => 'Not Modified',
        self::USE_PROXY          => 'Use Proxy',            // 1.1
        self::SWITCH_PROXY       => 'Switch Proxy',         // No longer used
        self::TEMPORARY_REDIRECT => 'Temporary Redirect',   // 1.1
        self::PERMANENT_REDIRECT => 'Permanent Redirect',   // 1.1; Experimental; http://www.ietf.org/rfc/rfc7238.txt
        // 4xx: Client error
        self::BAD_REQUEST                     => 'Bad Request',
        self::UNAUTHORIZED                    => 'Unauthorized',
        self::PAYMENT_REQUIRED                => 'Payment Required',
        self::FORBIDDEN                       => 'Forbidden',
        self::NOT_FOUND                       => 'Not Found',
        self::METHOD_NOT_ALLOWED              => 'Method Not Allowed',
        self::NOT_ACCEPTABLE                  => 'Not Acceptable',
        self::PROXY_AUTHENTICATION_REQUIRED   => 'Proxy Authentication Required',
        self::REQUEST_TIMEOUT                 => 'Request Timeout',
        self::CONFLICT                        => 'Conflict',
        self::GONE                            => 'Gone',
        self::LENGTH_REQUIRED                 => 'Length Required',
        self::PRECONDITION_FAILED             => 'Precondition Failed',
        self::PAYLOAD_TOO_LARGE               => 'Content Too Large',                 // https://www.iana.org/assignments/http-status-codes/http-status-codes.xml
        self::URI_TOO_LONG                    => 'URI Too Long',                      // https://www.iana.org/assignments/http-status-codes/http-status-codes.xml
        self::UNSUPPORTED_MEDIA_TYPE          => 'Unsupported Media Type',
        self::RANGE_NOT_SATISFIABLE           => 'Requested Range Not Satisfiable',
        self::EXPECTATION_FAILED              => 'Expectation Failed',
        self::IM_A_TEAPOT                     => "I'm a teapot",                      // April's Fools joke; http://www.ietf.org/rfc/rfc2324.txt
        self::MISDIRECTED_REQUEST             => 'Misdirected Request',               // http://www.iana.org/go/rfc7540 Section 9.1.2
        self::UNPROCESSABLE_ENTITY            => 'Unprocessable Content',             // https://www.iana.org/assignments/http-status-codes/http-status-codes.xml
        self::LOCKED                          => 'Locked',                            // http://www.iana.org/go/rfc4918
        self::FAILED_DEPENDENCY               => 'Failed Dependency',                 // http://www.iana.org/go/rfc4918
        self::TOO_EARLY                       => 'Too Early',                         // https://datatracker.ietf.org/doc/draft-ietf-httpbis-replay/
        self::UPGRADE_REQUIRED                => 'Upgrade Required',
        self::PRECONDITION_REQUIRED           => 'Precondition Required',             // 1.1; http://www.ietf.org/rfc/rfc6585.txt
        self::TOO_MANY_REQUESTS               => 'Too Many Requests',                 // 1.1; http://www.ietf.org/rfc/rfc6585.txt
        self::REQUEST_HEADER_FIELDS_TOO_LARGE => 'Request Header Fields Too Large',   // 1.1; http://www.ietf.org/rfc/rfc6585.txt
        self::UNAVAILABLE_FOR_LEGAL_REASONS   => 'Unavailable For Legal Reasons',     // http://tools.ietf.org/html/rfc7725
        // 5xx: Server error
        self::INTERNAL_ERROR                  => 'Internal Server Error',
        self::NOT_IMPLEMENTED                 => 'Not Implemented',
        self::BAD_GATEWAY                     => 'Bad Gateway',
        self::SERVICE_UNAVAILABLE             => 'Service Unavailable',
        self::GATEWAY_TIMEOUT                 => 'Gateway Timeout',
        self::HTTP_VERSION_NOT_SUPPORTED      => 'HTTP Version Not Supported',
        self::VARIANT_ALSO_NEGOTIATES         => 'Variant Also Negotiates',           // 1.1; http://www.ietf.org/rfc/rfc2295.txt
        self::INSUFFICIENT_STORAGE            => 'Insufficient Storage',              // http://www.iana.org/go/rfc4918
        self::LOOP_DETECTED                   => 'Loop Detected',                     // http://www.iana.org/go/rfc5842
        self::NOT_EXTENDED                    => 'Not Extended',                      // http://www.ietf.org/rfc/rfc2774.txt
        self::NETWORK_AUTHENTICATION_REQUIRED => 'Network Authentication Required',   // http://www.ietf.org/rfc/rfc6585.txt
        // Not officially supported
		self::PAGE_EXPIRED                  => 'Page Expired',
		self::INVALID_TOKEN                 => 'Invalid Token',
		self::CLIENT_CLOSED_REQUEST         => 'Client Closed Request',                // http://lxr.nginx.org/source/src/http/ngx_http_request.h#0133
		self::NO_RESPONSE                   => 'Connection Closed Without Respon0se',
		self::SITE_IS_OVERLOADED            => 'Site Is Overloaded',
		self::SITE_IS_FROZEN                => 'Site Is Frozen',
		self::TEMPORARILY_DISABLED          => 'Temporarily Disabled',
		self::NETWORK_CONNECT_TIMEOUT_ERROR => 'Network Connect Timeout Error',        // https://httpstatuses.com/599
    ];
}
