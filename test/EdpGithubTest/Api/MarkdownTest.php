<?php

namespace EdpGithubTest\Api;

use EdpGithub\Api\Markdown;

class MarkdownTest extends TestCase
{
    public function testRender()
    {
        $expectedResult = "<h1>Some MarkDown</h1>";

        $client = $this->getClientMock('markdown', $expectedResult);
        $api = new Markdown();
        $api->setClient($client);
        $result = $api->render('##Some Markdown');

        $this->assertEquals($expectedResult, $result);
    }
}
