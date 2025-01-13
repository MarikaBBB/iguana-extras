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

    it('should register actions correctly', function() {
        // expect($this->UseAtom)->toBeAnInstanceOf(\Dxw\Iguana\Registerable::class);
        \WP_Mock::expectActionAdded('init', [$this->useAtom, 'init']);
        \WP_Mock::expectActionAdded('wp_head', [$this->useAtom, 'wpHead']);

        $this->useAtom->register();
        
    });
});

