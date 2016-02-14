<?php

namespace App\Srp;

/**
 * Class Author
 * @package App\Srp
 */
class Author
{
    /**
     * @var string
     */
    private $name;

    /**
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }
}

/**
 * Class Book
 * @package App\Srp
 */
class Book
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var Author
     */
    private $author;

    /**
     * @var string
     */
    private $content;

    /**
     * @param $name
     * @param $content
     * @param $author
     */
    public function __construct($name, $content, Author $author)
    {
        $this->name = $name;
        $this->author = $author;
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return Author
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }
}

/**
 * Strategy Design Pattern
 *
 * Interface Strategy
 * @package App\Srp
 */
interface PrintStrategy
{
    public function printCover();
}

/**
 * Trait BookPrinter
 * @package App\Srp
 */
trait BookData
{
    /**
     * @var Book
     */
    private $book;

    /**
     * @param Book $book
     */
    public function __construct(Book $book)
    {
        $this->book = $book;
    }
}

/**
 * Class CoolHtmlCoverPrinter
 * @package App\Srp
 */
class CoolHtmlCoverPrinter implements PrintStrategy
{
    use BookData;

    /**
     * Print the html cover
     */
    public function printCover()
    {
        print '<div id="cover">' . $this->book->getName() . ' by ' . $this->book->getAuthor() . '</div>';
    }
}

/**
 * Class CoolHtmlCoverPrinter
 * @package App\Srp
 */
class PoorSimpleCoverPrinter implements PrintStrategy
{
    use BookData;

    /**
     * Print the simple cover
     */
    public function printCover()
    {
        print $this->book->getName() . ' by ' . $this->book->getAuthor();
    }
}

/**
 * Class BookPublisher
 * @package App\Srp
 */
class BookPublisher
{
    use BookData;

    /**
     * @param $path
     */
    public function save($path)
    {
        file_put_contents($path . '/' . $this->book->getName() . '.book', $this->book->getContent());
    }

    /**
     * @return string
     */
    public function publish()
    {
        return $this->call('http://mybooks.com/api/publish?name=' . $this->book->getName());
    }

    /**
     * @param $url
     * @return string
     */
    public function call($url)
    {
        return file_get_contents($url);
    }
}

/**
 * Create new Book
 */
$book = new Book(
    'The black Swan',
    '...',
    new Author('Nassim Nicholas Taleb')
);

/**
 * Print html cover
 */
$coolHtmlCoverPrinter = new CoolHtmlCoverPrinter($book);
$coolHtmlCoverPrinter->printCover();

/**
 * Publish the book
 */
$bookPublisher = new BookPublisher($book);
$bookPublisher->publish();
