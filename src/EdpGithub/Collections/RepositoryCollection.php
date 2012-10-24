<?php
namespace EdpGithub\Collections;

use Closure, ArrayIterator;

use EdpGithub\HttpClient\HttpClientInterface;

class RepositoryCollection
{
    /**
     * An array containing the entries of this collection.
     *
     * @var array
     */
    private $_elements;

    private $httpClient;

    private $pagination;

    /**
     * Initializes a new PaginationCollection.
     *
     * @param array $elements
     * @param array $pagination
     */
    public function __construct(array $elements = array(), $httpClient)
    {
        $this->httpClient = $httpClient;
        $response = $httpClient->getLastResponse();
        $this->setPagination($response->getPagination());
        $this->_elements = $elements;
    }

    protected function setPagination($pagination)
    {
        $this->pagination = $pagination;
    }

    /**
     * Gets the PHP array representation of this collection.
     *
     * @return array The PHP array representation of this collection.
     */
    public function toArray()
    {
        return $this->_elements;
    }

    /**
     * Get next Page.
     *
     * @return mixed
     */
    public function first()
    {
        return reset($this->_elements);
    }

    /**
     * Sets the internal iterator to the last element in the collection and
     * returns this element.
     *
     * @return mixed
     */
    public function last()
    {
        return end($this->_elements);
    }

    /**
     * Moves the internal iterator position to the next element.
     *
     * @return mixed
     */
    public function next()
    {
        $httpClient = $this->httpClient;
        $link = $this->pagination['next'];
        $path = $this->createPath($link);

        $response = $this->httpClient->request($path);
        $this->_elements = $response->getContent();
        $response = $httpClient->getLastResponse();
        $this->setPagination($response->getPagination());

        return $this;
    }

    protected function createPath($link)
    {
        $url = parse_url($link);
        parse_str($url['query'], $query);

        $params['page'] = $query['page'];
        $path = substr($url['path'], 1);
        $path .= '?'. utf8_encode(http_build_query($params, '', '&'));
        return $path;
    }

    /**
     * Gets the element of the collection at the current internal iterator position.
     *
     * @return mixed
     */
    public function current()
    {
        return current($this->_elements);
    }
}

