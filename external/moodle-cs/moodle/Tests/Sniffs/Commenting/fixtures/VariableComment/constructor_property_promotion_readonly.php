<?php

namespace MoodleHQ\MoodleCS\moodle\Tests\Sniffs\PHPUnit;

class cpp_only {
    public function __construct(
        protected readonly string $thing,
        /** @var string The other thing */
        public readonly string $otherthing,
        /**
         * Yes or no?
         *
         * @var BOOLEAN
         */
        public readonly bool $yesorno,
        /**
         * The page to do it on.
         *
         * @deprecated
         * @var \moodle_page
         */
        public readonly \moodle_page $page,
        /** @var string An attribute */
        #[\Attribute]
        public readonly string $attribute,
    ) {
    }
}
