<?php
use PHPUnit\Framework\TestCase;

use StreamDataBundle\Service\StreamDataService;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamWrapper;
use org\bovigo\vfs\vfsStreamDirectory;

class StreamDataServiceTest extends TestCase
{
    const FILE_DIR = 'data/';
    const FILE_NAME = 'data.csv';
    const ROW_COUNT = 5;
    protected $stream;
    protected $vFileSystem;

    public function setUp()
    {
        // vfsStreamWrapper::register();

        // $directory = [
        //     self::FILE_DIR => [
        //         self::FILE_NAME =>
        //             '"merchant";"date";"value"
        //              2;"01/05/2010";"£50.00"
        //              2;"01/05/2010";"$66.10"
        //              2;"02/05/2010";"€12.00"
        //              2;"02/05/2010";"£6.50"
        //              1;"02/05/2010";"£11.04"
        //              1;"02/05/2010";"€1.00"
        //              1;"03/05/2010";"$23.05"
        //              2;"04/05/2010";"€6.50"'
        //     ]
        // ];

        // $this->vFileSystem = vfsStream::setup('root', 444, $directory);
        // var_dump($this->vFileSystem->url());

        $this->stream = new StreamDataService(self::FILE_DIR, self::FILE_NAME);
    }

    /**
     * @dataProvider streamRowProvider
     */
    public function testFetchData($merchantId, $rows, $count)
    {
        $fetchedData = $this->stream->fetchData($merchantId);

        $this->assertArrayHasKey('header', $this->stream->fetchData($merchantId));
        $this->assertArrayHasKey('transactions', $this->stream->fetchData($merchantId));

        $this->assertCount($count, $fetchedData['transactions']);
    }

    public function streamRowProvider()
    {
        return array(
            array('2',
                array(
                    '"merchant";"date";"value"',
                    '2;"01/05/2010";"£50.00"',
                    '2;"01/05/2010";"$66.10"',
                    '2;"02/05/2010";"€12.00"',
                    '2;"02/05/2010";"£6.50"',
                    '1;"02/05/2010";"£11.04"',
                    '1;"02/05/2010";"€1.00"',
                    '1;"03/05/2010";"$23.05"',
                    '2;"04/05/2010";"€6.50"'
                ),
                self::ROW_COUNT
            )
        );
    }
}
