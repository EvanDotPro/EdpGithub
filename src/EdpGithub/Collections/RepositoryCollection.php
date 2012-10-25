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

    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * @var array
     */
    private $pagination;

    /**
     * Initializes a new RepositoryCollection.
     *
     * @param array $elements
     * @param array $httpClient
     */
    public function __construct(array $elements = array(),HttpClientInterface $httpClient)
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
     * Has First
     *
     * @return boolean
     */
    public function hasFirst()
    {
        if(isset($this->pagination['first'])) {
            return true;
        }

        return false;
    }

    /**
     * Get first Page.
     *
     * @return RepositoryCollection
     */
    public function first()
    {
        $this->request('first');

        return $this;
    }

    /**
     * Has Last
     *
     * @return boolean
     */
    public function hasLast()
    {
        if(isset($this->pagination['last'])) {
            return true;
        }

        return false;
    }

    /**
     * Get Last Page
     *
     * @return RepositoryCollection
     */
    public function last()
    {
        $this->request('last');

        return $this;
    }

    /**
     * Has Next
     *
     * @return boolean
     */
    public function hasNext()
    {
        if(isset($this->pagination['next'])) {
            return true;
        }

        return false;
    }

    /**
     * Get Next Page
     *
     * @return RepositoryCollection
     */
    public function next()
    {
        $this->request('next');

        return $this;
    }

    /**
     * Has Prev
     *
     * @return boolean
     */
    public function hasPrev()
    {
        if(isset($this->pagination['prev'])) {
            return true;
        }

        return false;
    }

    /**
     * Get Previous Page
     *
     * @return RepositoryCollection
     */
    public function prev()
    {
        $this->request('prev');

        return $this;
    }

    /**
     * Send Request
     *
     * @param  string
     */
    public function request($page)
    {
        $httpClient = $this->httpClient;
        $link = $this->pagination[$page];
        $path = $this->createPath($link);

        $response = $this->httpClient->request($path);
        $this->_elements = $response->getContent();
        $response = $httpClient->getLastResponse();

        $this->setPagination($response->getPagination());
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

    public function count()
    {
        return count($this->_elements);
    }

    /**
     * @see containsKey()
     */
    public function hasOffset($offset)
    {
        return $this->containsKey($offset);
    }

    /**
     * @see get()
     */
    public function getOffset($offset)
    {
        return $this->get($offset);
    }

    /**
     * @see add()
     * @see set()
     */
    public function setOffset($offset, $value)
    {
        if ( ! isset($offset)) {
            return $this->add($value);
        }

        return $this->set($offset, $value);
    }
}

