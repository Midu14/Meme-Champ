<?php

namespace App\Models;

use App\Helpers\DBConnection;
use Exception;

class Post {
    protected int $id;
    protected int $user_id;
    protected int $comp_id;
    protected string $title;
    protected string $img;
    protected string $created_at;

    public function __construct()
    {
        $this->id = 0;
        $this->user_id = 0;
        $this->comp_id = 0;
        $this->title = "";
        $this->img = "";
        $this->created_at = "";
    }

    public function load(int $id): ?Post
    {
        $pdo = DBConnection::getDB();
        $row = $pdo->query("SELECT * FROM post WHERE id=$id")->fetch();
        if ($row) {
            $this->id = $row['id'];
            $this->user_id = $row['user_id'];
            $this->comp_id = $row['comp_id'];
            $this->title = $row['title'];
            $this->img = $row['img'];
            $this->created_at = $row['created_at'];
            return $this;
        } else {
            return null;
        }
    }

    /**
     * @throws Exception
     */
    public function save(): ?Post
    {
        $pdo = DBConnection::getDB();
        if ($this->id != 0)
        {
            $stmt = $pdo->prepare("UPDATE post SET title=?, img=? WHERE id=?");
            $stmt->execute([$this->title, $this->img, $this->id]);
        }
        else
        {
            $competition = Competition::fetchCurrent();
            if (isset($competition['id'])) {
                $compId = $competition['id'];
                $stmt = $pdo->prepare("INSERT INTO post (user_id, comp_id, title, img) VALUES (?, ?, ?, ?)");
                $stmt->execute([$this->user_id, $compId, $this->title, $this->img]);
            } else {
                throw new Exception("Cannot create new post due to no active competitions");
            }

        }
        return $this;
    }

    public static function fetchAllInCurrentComp(): bool|array
    {
        $pdo = DBConnection::getDB();
        $currentComp = Competition::fetchCurrent();
        $compId = $currentComp['id'];
        return $pdo->query("SELECT post.id as post_id, user_id, title, img FROM post, competition WHERE comp_id=competition.id AND competition.id=$compId ORDER BY post.id DESC")->fetchAll();
    }

    public static function fetchPostsWithTotalVotes(): array
    {
        $competition = Competition::fetchCurrent();
        $compId = $competition['id'];
        $posts = DBConnection::getDB()->query("SELECT * FROM post WHERE comp_id=$compId")->fetchAll();

        $result = [];

        foreach ($posts as $post) {
            $post['totalVotes'] = Vote::getTotalVotesForPost($post['id']);
            array_push($result, $post);
        }

        return $result;
    }

    public static function build(int $ownerId, string $title, string $image): Post
    {
        $post = new Post();
        $post->setUserId($ownerId);
        $post->setTitle($title);
        $post->setImg($image);
        return $post;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     */
    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @return int
     */
    public function getCompId(): int
    {
        return $this->comp_id;
    }

    /**
     * @param int $comp_id
     */
    public function setCompId(int $comp_id): void
    {
        $this->comp_id = $comp_id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getImg(): string
    {
        return $this->img;
    }

    /**
     * @param string $img
     */
    public function setImg(string $img): void
    {
        $this->img = $img;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    /**
     * @param string $created_at
     */
    public function setCreatedAt(string $created_at): void
    {
        $this->created_at = $created_at;
    }
}
