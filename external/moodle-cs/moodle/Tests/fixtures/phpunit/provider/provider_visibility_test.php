<?php
defined('MOODLE_INTERNAL') || die(); // Make this always the 1st line in all CS fixtures.

class provider_visibility_test extends base_test {
    /**
     * @dataProvider provider
     */
    public function test_one(): void {
        // Nothing to test.
    }

    private static function provider(): array {
        return [];
    }

    /**
     * @dataProvider provider_without_visibility
     */
    public function test_two(): void {
        // Nothing to test.
    }

    function provider_without_visibility(): array {
        return [];
    }

    /**
     * @dataProvider static_provider_without_visibility
     */
    public function test_three_two(): void {
        // Nothing to test.
    }

    static function static_provider_without_visibility(): array {
        return [];
    }
}
