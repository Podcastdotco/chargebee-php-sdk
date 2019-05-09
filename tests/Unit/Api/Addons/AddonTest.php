<?php

namespace Tests\Unit\Api\Addons;

use NathanDunn\Chargebee\Api\Addons\Addon;
use Symfony\Component\OptionsResolver\Exception\UndefinedOptionsException;
use Tests\Unit\Api\TestCase;

class AddonTest extends TestCase
{
    /** @test */
    public function should_list_addons()
    {
        $expected = $this->getContent(sprintf('%s/data/responses/addon_list.json', __DIR__));

        $addon = $this->getApiMock();
        $addon->expects($this->once())
            ->method('get')
            ->with('https://123456789.chargebee.com/api/v2/addons', [])
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $addon->list());
    }

    /** @test */
    public function should_find_addon()
    {
        $expected = $this->getContent(sprintf('%s/data/responses/addon.json', __DIR__));

        $addon = $this->getApiMock();
        $addon->expects($this->once())
            ->method('get')
            ->with('https://123456789.chargebee.com/api/v2/addons/ssl', [])
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $addon->find('ssl'));
    }

    /** @test */
    public function should_create_addon()
    {
        $expected = $this->getContent(sprintf('%s/data/responses/addon_created.json', __DIR__));

        $addon = $this->getApiMock();
        $addon->expects($this->once())
            ->method('post')
            ->with('https://123456789.chargebee.com/api/v2/addons', [])
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $addon->create([]));
    }

    /** @test */
    public function should_update_addon()
    {
        $expected = $this->getContent(sprintf('%s/data/responses/addon_updated.json', __DIR__));

        $addon = $this->getApiMock();
        $addon->expects($this->once())
            ->method('post')
            ->with('https://123456789.chargebee.com/api/v2/addons/ssl', [])
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $addon->update('ssl', []));
    }

    /** @test */
    public function should_delete_addon()
    {
        $expected = $this->getContent(sprintf('%s/data/responses/addon_deleted.json', __DIR__));

        $addon = $this->getApiMock();
        $addon->expects($this->once())
            ->method('post')
            ->with('https://123456789.chargebee.com/api/v2/addons/ssl/delete', [])
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $addon->delete('ssl'));
    }

    /** @test */
    public function should_copy_addon()
    {
        $expected = $this->getContent(sprintf('%s/data/responses/addon_copied.json', __DIR__));

        $addon = $this->getApiMock();
        $addon->expects($this->once())
            ->method('post')
            ->with('https://123456789.chargebee.com/api/v2/addons/copy', [])
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $addon->copy([]));
    }

    /** @test */
    public function should_unarchive_addon()
    {
        $expected = $this->getContent(sprintf('%s/data/responses/addon_unarchived.json', __DIR__));

        $addon = $this->getApiMock();
        $addon->expects($this->once())
            ->method('post')
            ->with('https://123456789.chargebee.com/api/v2/addons/ssl/unarchive', [])
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $addon->unarchive('ssl'));
    }

    /**
     * @test
     * @dataProvider filters_provider
     */
    public function it_should_filter_addons($filters)
    {
        $expected = $this->getContent(sprintf('%s/data/responses/addon_list.json', __DIR__));

        $addon = $this->getApiMock();
        $addon->expects($this->once())
            ->method('get')
            ->with('https://123456789.chargebee.com/api/v2/addons', $filters)
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $addon->list($filters));
    }

    /**
     * @return array
     */
    public function filters_provider(): array
    {
        return [
            'status' => [['status[is]' => 'active']],
        ];
    }

    /**
     * @test
     */
    public function should_reject_unregistered_filters()
    {
        $filters = ['unkown' => 'field'];

        $expected = $this->getContent(sprintf('%s/data/responses/addon_list.json', __DIR__));

        $addon = $this->getApiMock();
        $addon->expects($this->never())
            ->method('get');

        $this->expectException(UndefinedOptionsException::class);
        $addon->list($filters);
    }

    /**
     * @return string
     */
    protected function getApiClass()
    {
        return Addon::class;
    }
}
