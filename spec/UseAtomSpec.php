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
            allow('add_action')->tobeCalled()->with('init', [$this->useAtom, 'init']);
            allow('add_action')->tobeCalled()->with('wp_head', [$this->useAtom, 'wpHead']);

    
            
            $this->useAtom->register();           
        });
    });

    describe('::init()', function() {
        it('adds the default_feed filter correctly', function() {
            allow('add_filter')->tobeCalled()->with('default_feed',[$this->useAtom, 'defaultFeed']);
            allow('remove_action')->tobeCalled()->with('do_feed_rdf', 'do_feed_rdf', 10, 1);
            allow('remove_action')->tobeCalled()->with('do_feed_rss', 'do_feed_rss', 10, 1);
            allow('remove_action')->tobeCalled()->with('do_feed_rss2', 'do_feed_rss2', 10, 1);

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
            allow('get_bloginfo')->toBeCalled()->andReturn('Xyz');
            allow('esc_attr')->toBeCalled()->andRun(function ($a) {
                return '_'.$a.'_';
            });
            allow('get_feed_link')->toBeCalled()->with('atom')->andReturn('xyz');

           
            ob_start();
            $results = $this->useAtom->wpHead();
            $results = ob_get_clean();

            expect($results)->toBeA('string');
            expect(false)->toBeA('boolean');
            expect($results)->toBe('        <link rel="alternate" type="application/atom+xml" title="_Xyz_ Feed" href="_xyz_">'."\n        ");
        });
    });
});
