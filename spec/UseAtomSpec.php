<?php

use Dxw\Iguana\Extras\UseAtom;

describe('UseAtom', function() {
    // initialisation
    beforeEach(function () {
        $this->useAtom = new \Dxw\Iguana\Extras\UseAtom();
        \WP_Mock::setUp();
    });

    afterEach(function() {
        \WP_Mock::tearDown();
    });

    describe("::register()", function() {
        it('should register actions correctly', function() {
            \WP_Mock::expectActionAdded('init', [$this->useAtom, 'init']);
            \WP_Mock::expectActionAdded('wp_head', [$this->useAtom, 'wpHead']);
    
            
            $this->useAtom->register();           
        });
    });

    describe('::init()', function() {
        it('adds the default_feed filter correctly', function() {
            \WP_Mock::expectFilterAdded('default_feed', [$this->useAtom, 'defaultFeed']);

            \WP_Mock::wpFunction('remove_action', [
                'args' => ['do_feed_rdf', 'do_feed_rdf', 10, 1],
                'times' => 1,
            ]);
            \WP_Mock::wpFunction('remove_action', [
                'args' => ['do_feed_rss', 'do_feed_rss', 10, 1],
                'times' => 1,
            ]);
            \WP_Mock::wpFunction('remove_action', [
                'args' => ['do_feed_rss2', 'do_feed_rss2', 10, 1],
                'times' => 1,
            ]);

            // Call init() method
            $this->useAtom->init();
        });

        it("removes the actions", function() {
            \WP_Mock::wpFunction('remove_action', [
                'args' => ['do_feed_rdf', 'do_feed_rdf', 10, 1],
                'times' => 1,
            ]);
            \WP_Mock::wpFunction('remove_action', [
                'args' => ['do_feed_rss', 'do_feed_rss', 10, 1],
                'times' => 1,
            ]);
            \WP_Mock::wpFunction('remove_action', [
                'args' => ['do_feed_rss2', 'do_feed_rss2', 10, 1],
                'times' => 1,
            ]);

            // Call init() method
            $this->useAtom->init();
        });

        // Check that this code runs to completion without errors
        it('completes execution without errors', function() {
            expect(function () {
                $this->useAtom->init();
            })->not->toThrow();            
        });
    });

    describe('::wpHead()', function() {
        it('outputs the correct link in wp_head', function() {
            \WP_Mock::wpFunction('get_bloginfo', [
                'args' => ['name'],
                'return' => 'Xyz',
            ]);
    
            \WP_Mock::wpFunction('esc_attr', [
                'return' => function ($a) {
                    return '_'.$a.'_';
                },
            ]);
    
            \WP_Mock::wpFunction('get_feed_link', [
                'args' => ['atom'],
                'return' => 'xyz',
            ]);

           
            ob_start();
            $results = $this->useAtom->wpHead();
            $results = ob_get_clean();

            expect($results)->toBeA('string');
            expect(false)->toBeA('boolean');
            expect($results)->toBe('        <link rel="alternate" type="application/atom+xml" title="_Xyz_ Feed" href="_xyz_">'."\n        ");
        });
    });
});
