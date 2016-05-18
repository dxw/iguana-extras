<?php

class UseAtom_Test extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        \WP_Mock::setUp();
    }

    public function tearDown()
    {
        \WP_Mock::tearDown();
    }

    public function testRegister()
    {
        $useAtom = new \Dxw\Iguana\Extras\UseAtom();

        $this->assertInstanceOf(\Dxw\Iguana\Registerable::class, $useAtom);

        \WP_Mock::expectActionAdded('init', [$useAtom, 'init']);
        \WP_Mock::expectActionAdded('wp_head', [$useAtom, 'wpHead']);

        $useAtom->register();
    }

    public function testInit()
    {
        $useAtom = new \Dxw\Iguana\Extras\UseAtom();

        \WP_Mock::expectFilterAdded('default_feed', [$useAtom, 'defaultFeed']);

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

        $useAtom->init();
    }

    public function testDefaultFeed()
    {
        $useAtom = new \Dxw\Iguana\Extras\UseAtom();

        $this->assertEquals('atom', $useAtom->defaultFeed());
    }

    public function testWpHead()
    {
        $useAtom = new \Dxw\Iguana\Extras\UseAtom();

        \WP_Mock::wpFunction('get_bloginfo', [
            'args' => ['name'],
            'return' => 'Xyz',
        ]);

        \WP_Mock::wpFunction('esc_attr', [
            'return' => function ($a) { return '_'.$a.'_'; },
        ]);

        \WP_Mock::wpFunction('get_feed_link', [
            'args' => ['atom'],
            'return' => 'xyz',
        ]);

        $this->expectOutputString('        <link rel="alternate" type="application/atom+xml" title="_Xyz_ Feed" href="_xyz_">'."\n        ");

        $useAtom->wpHead();
    }
}
