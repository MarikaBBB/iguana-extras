<?php

use Dxw\Iguana\Extras\UseAtom;

describe('UseAtom', function () {
	// initialisation
	beforeEach(function () {
		$this->useAtom = new \Dxw\Iguana\Extras\UseAtom();
        
        allow('add_action')->toBeCalled();
	});

	afterEach(function () {
        unset($this->useAtom);
	});

	describe("::register()", function () {
		it('should register actions correctly', function () {
			allow('add_action')->toBeCalled();
			expect('add_action')->toBeCalled()->times(2);
			expect('add_action')->toBeCalled()->once()->with('init', [$this->useAtom, 'init']);
			expect('add_action')->toBeCalled()->once()->with('wp_head', [$this->useAtom, 'wpHead']);

			$this->useAtom->register();
		});
	});

	describe('::init()', function () {
		it('adds the default_feed filter and removes actions correctly', function () {
			allow('add_filter')->toBeCalled();
            allow('remove_action')->toBeCalled();


            // Assertions
			expect('add_filter')->toBeCalled()->once()->with('default_feed', [$this->useAtom, 'defaultFeed']);
			expect('remove_action')->toBeCalled()->times(3);
			expect('remove_action')->toBeCalled()->with('do_feed_rdf', 'do_feed_rdf', 10, 1);
			expect('remove_action')->toBeCalled()->with('do_feed_rss', 'do_feed_rss', 10, 1);
			expect('remove_action')->toBeCalled()->with('do_feed_rss2', 'do_feed_rss2', 10, 1);

            $this->useAtom->init();
			
		});



		// Check that this code runs to completion without errors
		it('completes execution without errors', function () {
            allow('add_filter')->toBeCalled();
            allow('remove_action')->toBeCalled();

			expect(function () {
				$this->useAtom->init();
			})->not->toThrow();
		});
	});

	describe('::wpHead()', function () {
		it('outputs the correct link in wp_head', function () {
			allow('get_bloginfo')->toBeCalled()->andReturn('Xyz');
			expect('get_bloginfo')->toBeCalled()->once()->with('name');



			allow('esc_attr')->toBeCalled()->andRun(function ($a) {
				return '_'.$a.'_';
			});
			expect('esc_attr')->toBeCalled()->with('xyz');


			allow('get_feed_link')->toBeCalled()->andReturn('xyz');
			expect('get_feed_link')->toBeCalled()->once()->with('atom');


			ob_start();
			$this->useAtom->wpHead();
			$results = ob_get_clean();


			expect($results)->toBe('        <link rel="alternate" type="application/atom+xml" title="_Xyz_ Feed" href="_xyz_">'."\n        ");
		});
	});
});
