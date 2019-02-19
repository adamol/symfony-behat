<?php

use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Context\Context;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * This context class contains the definitions of the steps used by the demo
 * feature file. Learn how to get started with Behat and BDD on Behat's website.
 *
 * @see http://behat.org/en/latest/quick_start.html
 */
class FeatureContext implements Context
{
    /**
     * @var KernelInterface
     */
    private $kernel;

    /**
     * @var Response|null
     */
    private $response;

    /**
    * @var array
    */
    private $headers = [];

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @When a demo scenario sends a request to :path
     */
    public function aDemoScenarioSendsARequestTo(string $path)
    {
        $this->response = $this->kernel->handle(Request::create($path, 'GET'));
    }

    /**
     * @Then the response should be received
     */
    public function theResponseShouldBeReceived()
    {
        if ($this->response === null) {
            throw new \RuntimeException('No response received');
        }
    }

    /**
     * @When I add :key header equal to :value
     */
    public function iAddHeaderEqualTo($key, $value)
    {
        $this->headers[$key] = $value;
    }

    /**
     * @When I send a :method request to :uri with body:
     */
    public function iSendARequestToWithBody($method, $uri, PyStringNode $body)
    {
        $params = $body !== null ? $body->getRaw() : [];
        $params = json_decode($params, true);
        $this->response = $this->kernel->handle(Request::create($uri, $method, $params));
    }

    /**
     * @Then the response status code should be :expected
     */
    public function theResponseStatusCodeShouldBe(int $expected)
    {
        if ($this->response === null) {
            throw new \RuntimeException('No response received');
        }

        $actual = (int) $this->response->getStatusCode();
        if ($actual !== $expected) {
            throw new \RuntimeException(sprintf(
                'Expected status code "%d". "%d" provided.',
                $expected,
                $actual
            ));
        }
    }

    /**
     * @Then the response should be in JSON
     */
    public function theResponseShouldBeInJson()
    {
        $this->decode($this->response);

        if (\json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException('invalid json body: ' . json_last_error_msg());
        }
    }

    private function decode($response)
    {
        return json_decode($response->getContent(), true);
    }

    /**
     * @Then the header :key should be equal to :expected
     */
    public function theHeaderShouldBeEqualTo($key, $expected)
    {
        $actual = $this->response->headers->get($key);
        if ($actual !== $expected) {
            throw new \RuntimeException(sprintf(
                'Header "%s" does not match expected "%s".',
                $actual,
                $expected
            ));
        }
    }

    /**
     * @Then the JSON nodes should contain:
     */
    public function theJsonNodesShouldContain(TableNode $nodes)
    {
        foreach ($nodes->getRowsHash() as $node => $text) {
            $this->theJsonNodeShouldContain($node, $text);
        }
    }

    /**
     * Checks, that given JSON node contains given value
     *
     * @Then the JSON node :node should contain :text
     */
    public function theJsonNodeShouldContain($node, $text)
    {
        $json = $this->decode($this->response);

        $actual = $json[$node];

        \PHPUnit\Framework\Assert::assertContains($text, (string) $actual);
    }

    /**
     * @Then the JSON node :node should be true
     */
    public function theJsonNodeShouldBeTrue($node)
    {
        $json = $this->decode($this->response);

        $actual = $json[$node];

        if (true !== $actual) {
            throw new \Exception(
                sprintf('The node value is `%s`', json_encode($actual))
            );
        }
    }
}

