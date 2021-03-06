<?php

namespace Tests\Unit\Live\Service;

use AppBundle\Common\ReflectionUtils;
use Biz\BaseTestCase;
use Biz\Live\Dao\LiveStatisticsDao;
use Biz\Live\LiveStatisticsProcessor\LiveStatisticsProcessorFactory;
use Biz\Live\Service\LiveStatisticsService;
use Biz\Util\EdusohoLiveClient;

class LiveStatisticsServiceTest extends BaseTestCase
{
    public function testCreateLiveCheckinStatistics()
    {
        $this->mockLiveClient(LiveStatisticsService::STATISTICS_TYPE_CHECKIN);
        $mockedProcessor = $this->mockProcessor();

        ReflectionUtils::setStaticProperty(new LiveStatisticsProcessorFactory(), 'mockedProcessor', $mockedProcessor);

        $liveId = 1;
        $result = $this->getLiveStatisticsService()->createLiveCheckinStatistics($liveId);

        $mockedProcessor->shouldHaveReceived('handlerResult')->times(1);

        $this->assertEquals($liveId, $result['liveId']);
        $this->assertEquals(LiveStatisticsService::STATISTICS_TYPE_CHECKIN, $result['type']);
        $this->assertEquals(array('data' => array(
            'success' => 1,
            'detail' => 'test detail',
        )), $result['data']);
    }

    public function testCreateLiveVisitorStatistics()
    {
        $this->mockLiveClient(LiveStatisticsService::STATISTICS_TYPE_VISITOR);
        $mockedProcessor = $this->mockProcessor();

        ReflectionUtils::setStaticProperty(new LiveStatisticsProcessorFactory(), 'mockedProcessor', $mockedProcessor);

        $liveId = 1;
        $result = $this->getLiveStatisticsService()->createLiveVisitorStatistics($liveId);

        $mockedProcessor->shouldHaveReceived('handlerResult')->times(1);

        $this->assertEquals($liveId, $result['liveId']);
        $this->assertEquals(LiveStatisticsService::STATISTICS_TYPE_VISITOR, $result['type']);
        $this->assertEquals(array('data' => array('success' => 1,
            'detail' => 'test detail', )), $result['data']);
    }

    public function testGetCheckinStatisticsByLiveId()
    {
        $liveId = 1;
        $result = $this->getLiveStatisticsService()->getCheckinStatisticsByLiveId($liveId);
        $this->assertNull($result);

        $existedCheckin = $this->createCheckinStatistics($liveId);
        $existedVisitor = $this->createVisitorStatistics($liveId);

        $result = $this->getLiveStatisticsService()->getCheckinStatisticsByLiveId($liveId);

        $this->assertEquals($existedCheckin['id'], $result['id']);
    }

    public function testGetVisitorStatisticsByLiveId()
    {
        $liveId = 1;
        $result = $this->getLiveStatisticsService()->getVisitorStatisticsByLiveId($liveId);
        $this->assertNull($result);

        $existedCheckin = $this->createCheckinStatistics($liveId);
        $existedVisitor = $this->createVisitorStatistics($liveId);

        $result = $this->getLiveStatisticsService()->getVisitorStatisticsByLiveId($liveId);

        $this->assertEquals($existedVisitor['id'], $result['id']);
    }

    public function testUpdateCheckinStatistics_WithoutExistedStatistics()
    {
        $this->mockLiveClient(LiveStatisticsService::STATISTICS_TYPE_CHECKIN);
        $mockedProcessor = $this->mockProcessor();

        ReflectionUtils::setStaticProperty(new LiveStatisticsProcessorFactory(), 'mockedProcessor', $mockedProcessor);

        $liveId = 1;
        $result = $this->getLiveStatisticsService()->updateCheckinStatistics($liveId);

        $mockedProcessor->shouldHaveReceived('handlerResult')->times(1);

        $this->assertEquals($liveId, $result['liveId']);
        $this->assertEquals(LiveStatisticsService::STATISTICS_TYPE_CHECKIN, $result['type']);
        $this->assertEquals(array('data' => array('success' => 1,
            'detail' => 'test detail', )), $result['data']);
    }

    public function testUpdateCheckinStatistics_WithExistedStatistics()
    {
        $this->mockLiveClient(LiveStatisticsService::STATISTICS_TYPE_CHECKIN);
        $mockedProcessor = $this->mockProcessor();

        ReflectionUtils::setStaticProperty(new LiveStatisticsProcessorFactory(), 'mockedProcessor', $mockedProcessor);

        $liveId = 1;

        $existed = $this->createCheckinStatistics($liveId);
        $result = $this->getLiveStatisticsService()->updateCheckinStatistics($liveId);

        $mockedProcessor->shouldHaveReceived('handlerResult')->times(1);

        $this->assertEquals($liveId, $existed['liveId']);
        $this->assertEquals(LiveStatisticsService::STATISTICS_TYPE_CHECKIN, $existed['type']);
        $this->assertEmpty($existed['data']);

        $this->assertEquals($liveId, $result['liveId']);
        $this->assertEquals(LiveStatisticsService::STATISTICS_TYPE_CHECKIN, $result['type']);
        $this->assertEmpty($result['data']);
    }

    public function testUpdateVisitorStatistics_WithoutExistedStatistics()
    {
        $this->mockLiveClient(LiveStatisticsService::STATISTICS_TYPE_VISITOR);
        $mockedProcessor = $this->mockProcessor();

        ReflectionUtils::setStaticProperty(new LiveStatisticsProcessorFactory(), 'mockedProcessor', $mockedProcessor);

        $liveId = 1;
        $result = $this->getLiveStatisticsService()->updateVisitorStatistics($liveId);

        $mockedProcessor->shouldHaveReceived('handlerResult')->times(1);

        $this->assertEquals($liveId, $result['liveId']);
        $this->assertEquals(LiveStatisticsService::STATISTICS_TYPE_VISITOR, $result['type']);
        $this->assertEquals(array('data' => array('success' => 1,
            'detail' => 'test detail', )), $result['data']);
    }

    public function testUpdateVisitorStatistics_WithExistedStatistics()
    {
        $this->mockLiveClient(LiveStatisticsService::STATISTICS_TYPE_VISITOR);
        $mockedProcessor = $this->mockProcessor();

        ReflectionUtils::setStaticProperty(new LiveStatisticsProcessorFactory(), 'mockedProcessor', $mockedProcessor);

        $liveId = 1;

        $existed = $this->createVisitorStatistics($liveId);
        $result = $this->getLiveStatisticsService()->updateVisitorStatistics($liveId);

        $mockedProcessor->shouldHaveReceived('handlerResult')->times(1);

        $this->assertEquals($liveId, $existed['liveId']);
        $this->assertEquals(LiveStatisticsService::STATISTICS_TYPE_VISITOR, $existed['type']);
        $this->assertEmpty($existed['data']);

        $this->assertEquals($liveId, $result['liveId']);
        $this->assertEquals(LiveStatisticsService::STATISTICS_TYPE_VISITOR, $result['type']);
        $this->assertEmpty($result['data']);
    }

    public function testFindCheckinStatisticsByLiveIds()
    {
        $liveIds = array(1, 2, 4);
        $result = $this->getLiveStatisticsService()->findCheckinStatisticsByLiveIds($liveIds);

        $this->assertEmpty($result);

        $expected = array();
        $expected[1] = $this->createCheckinStatistics(1);
        $expected[2] = $this->createCheckinStatistics(2);
        $this->createCheckinStatistics(3);

        $result = $this->getLiveStatisticsService()->findCheckinStatisticsByLiveIds($liveIds);

        $this->assertCount(2, $result);
        $this->assertEquals($expected, $result);
    }

    public function testFindVisitorStatisticsByLiveIds()
    {
        $liveIds = array(1, 2, 4);
        $result = $this->getLiveStatisticsService()->findVisitorStatisticsByLiveIds($liveIds);

        $this->assertEmpty($result);

        $expected = array();
        $expected[1] = $this->createVisitorStatistics(1);
        $expected[2] = $this->createVisitorStatistics(2);
        $this->createVisitorStatistics(3);

        $result = $this->getLiveStatisticsService()->findVisitorStatisticsByLiveIds($liveIds);

        $this->assertCount(2, $result);
        $this->assertEquals($expected, $result);
    }

    protected function createCheckinStatistics($liveId)
    {
        return $this->getLiveStatisticsDao()->create(array('liveId' => $liveId, 'type' => LiveStatisticsService::STATISTICS_TYPE_CHECKIN, 'data' => array()));
    }

    protected function createVisitorStatistics($liveId)
    {
        return $this->getLiveStatisticsDao()->create(array('liveId' => $liveId, 'type' => LiveStatisticsService::STATISTICS_TYPE_VISITOR, 'data' => array()));
    }

    protected function mockProcessor()
    {
        return $this->mockBiz(
            'Mocked:MockedProcessor',
            array(
                array(
                    'functionName' => 'handlerResult',
                    'returnValue' => array(
                        'data' => array(
                            'success' => 1,
                            'detail' => 'test detail',
                        ),
                    ),
                ),
            )
        );
    }

    protected function mockLiveClient($type)
    {
        $liveClient = new EdusohoLiveClient();
        $mockObject = \Mockery::mock($liveClient);

        if (LiveStatisticsService::STATISTICS_TYPE_CHECKIN == $type) {
            $mockObject->shouldReceive('getLiveRoomCheckinList')->times(1)->andReturn(array(
                'code' => 0,
                'data' => array(),
            ));
        }

        if (LiveStatisticsService::STATISTICS_TYPE_VISITOR == $type) {
            $mockObject->shouldReceive('getLiveRoomHistory')->times(1)->andReturn(array(
                'code' => 0,
                'data' => array(),
            ));
        }

        $biz = $this->getBiz();
        $biz['educloud.live_client'] = $mockObject;
    }

    /**
     * @return LiveStatisticsService
     */
    protected function getLiveStatisticsService()
    {
        return $this->createService('Live:LiveStatisticsService');
    }

    /**
     * @return LiveStatisticsDao
     */
    protected function getLiveStatisticsDao()
    {
        return $this->createDao('Live:LiveStatisticsDao');
    }
}
