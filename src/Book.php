<?php
    class Book
    {
        private $title;
        private $id;

        function __construct($title, $id = null)
        {
            $this->title = $title;
            $this->id = $id;
        }

        function setTitle($title)
        {
            $this->title = $title;
        }

        function getTitle()
        {
            return $this->title;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO books (title) VALUES ('{$this->getTitle()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_books = $GLOBALS['DB']->query("SELECT * FROM books;");
            $books = array();
            foreach ($returned_books as $book) {
                $title = $book['title'];
                $id = $book['id'];
                $new_book = new Book($title, $id);
                array_push($books, $new_book);
            }
            return $books;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM books;");
        }

        // function updateBook($new_title)
        // {
        //     $GLOBALS['DB']->exec("UPDATE books SET title = '{$new_title}' WHERE id = {$this->getId()};");
        //     $this->setTitle($new_title);
        // }

        function deleteBook()
        {
            $GLOBALS['DB']->exec("DELETE FROM books WHERE id = {$this->getId()};");
        }

        static function findBook($search_id)
        {
            $found_book = null;
            $books = Book::getAll();
            foreach ($books as $book) {
                $book_id = $book->getId();
                if ($book_id == $search_id) {
                  $found_book = $book;
                }
            }
            return $found_book;
        }


      }
?>
