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
            // expect($this->UseAtom)->toBeAnInstanceOf(\Dxw\Iguana\Registerable::class);
            \WP_Mock::expectActionAdded('init', [$this->useAtom, 'init']);
            \WP_Mock::expectActionAdded('wp_head', [$this->useAtom, 'wpHead']);
    
            $this->useAtom->register();           
        });
    });

    describe('::init()', function() {
        
        it('starts correclty by removing filters and actions', function() {
            \WP_Mock::expectFilterAdded('default_feed', [$this->useAtom, 'defaultFeed']);

            $this->useAtmon->init();
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

            $this->useAtom->init();
        });

        // Check that this code runs to completion.
        it('completes execution without errors', function() {
            expect(function() {
                $this->useAtom->init();
            })->not->toThrow();
        });
    });

    


    
});