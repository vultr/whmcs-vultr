<?php

namespace MGModule\vultr\mgLibs\exceptions;

/**
 * Used in Error Handler
 *
 * @author Michal Czech <michael@modulesgarden.com>
 */
class syntaxError extends System {
    private $_type;
    private $_line;
    private $_file;
    public function __construct($message, $type, $code, $line, $file) {
        $this->_type = $type;
        $this->_code = $code;
        $this->_line = $line;
        $this->_file = $file;
        parent::__construct($message, $code);
    }
}
