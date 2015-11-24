<?php

class Book {
    private $name;
    private $author;
    private $content;

    public function getName() {
        return $this->name;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function printHtmlCover() {
        echo '<div id="cover">' . $this->getName() . ' by ' . $this->getAuthor() . '</div>';
    }

    public function printSimpleCover() {
        echo $this->getName() . ' by ' . $this->getAuthor();
    }

    public function save($path) {
        file_put_contents($path . '/' . $this->getName() . '.book', $this->content);
    }

    public function publish() {
        $this->call('http://mybooks.com/api/publish?name=' . $this->getName());
    }

    public function call($url) {
        file_get_contents($url);
    }
}