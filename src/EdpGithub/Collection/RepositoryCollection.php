<?php

namespace EdpGithub\Collection;

use EdpGithub\Http\Client;
use EdpGithub\Api\Model\Repo as RepoModel;

use Closure, Iterator;

class RepositoryCollection implements Iterator
{
    /**
     * @var client
     */
    protected $httpClient;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var array
     */
    protected $parameters;

    /**
     * @var array
     */
    protected $headers;

    /**
     * @var array
     */
    protected $elements = array();

    protected $pagination = null;

    protected $page = 1;

    private $perPage;

    public function __construct(Client $httpClient, $path, array $parameters =array(),$perPage = 30, array $headers = array())
    {
            $this->httpClient = $httpClient;
            $this->path = $path;
            $this->headers = $headers;
            $this->perPage = $perPage;
    }

    private function loadPage($page)
    {
        if($this->pagination == null) {
            $this->parameters['page'] = 1;
            $elements = $this->fetch();

            $offset = 0;

            foreach($elements as $element) {
                $this->add($offset++, $element);
            }
        }

        if($page > $this->pagination['last']) {
            return false;
        }

        if($page != 1) {
            $this->parameters['page'] = $page;
            $elements = $this->fetch();
        }

        $offset = (($page-1) * $this->perPage);

        foreach($elements as $element) {
            $this->add($offset++, $element);
        }

        return true;
    }

    private function fetch()
    {
        $response = $this->httpClient->get($this->path, $this->parameters, $this->headers);
        $this->getPagination($response);

        $elements = json_decode($response->getBody(), true);
        return $elements;
    }

    public function page($page)
    {
        $this->parameters['per_page'] = $this->perPage;
        $offsetStart = (($page-1) * $this->perPage);
        $limit = $this->perPage -1;
        $elements = array();

        for($offset=$offsetStart,$i=0;$i<=$limit; $i++, $offset++){
            if(!$this->containsKey($offset)) {
                if($this->loadPage($page)) {
                    $elements[] = $this->get($offset);
                } else {
                    break;
                }
            } else  {
                $elements[] = $this->get($offset);
            }
        }

        return $elements;
    }

    public function add($offset, $element)
    {
        $this->elements[$offset] = $this->hydrate($element);
    }


    private function getPagination($response)
    {
        $this->pagination['last'] = 1;
        $headers= $response->getHeaders();
        if($headers->has('Link')) {
            $header = $headers->get('Link')->getFieldValue();

            if (empty($header)) {
                return null;
            }

            $pagination = array();
            foreach (explode(',', $header) as $link) {
                preg_match('/<(.*)>; rel="(.*)"/i', trim($link, ','), $match);

                if (3 === count($match)) {
                    $pagination[$match[2]] = $match[1];
                }
            }
            if(isset($pagination['last'])) {
                $url = parse_url($pagination['last']);
                parse_str($url['query'], $query);
                $this->pagination['last'] = $query['page'];
            }
        }
    }

    public function rewind()
    {
        reset($this->elements);
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        return current($this->elements);
    }

    public function get($key)
    {
        return $this->elements[$key];
    }
    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return key($this->elements);
    }

    public function first()
    {
        return $this->rewind();
    }
    /**
     * {@inheritdoc}
     */
    public function next()
    {

        return next($this->elements);
    }

    public function prev()
    {
        return prev($this->elements);
    }

    public function getIterator()
    {
        $this->rewind();
        $this->page = 1;
        $this->parameters['per_page'] = 100;

        return $this;
    }

    public function valid()
    {
        if(!$this->current()) {
            return $this->loadPage(++$this->page);
        }
        return true;
    }

    public function containsKey($key)
    {
        return array_key_exists($key, $this->elements);
    }

    public function count()
    {
        return count($this->elements);
    }

    public function indexOf($element)
    {
        return array_search($element, $this->elements);
    }

    public function removeElement($element) {
        $key = $this->indexOf($element);

        if($key) {
            unset($this->elements[$key]);
            return true;
        }
        return false;
    }

    public function toArray()
    {
        return $this->elements;
    }

    public function hydrate($element)
    {
        return  new RepoModel($element);
    }
}