<?php

namespace App\Models;

use App\Helpers\DBConnection;
use App\Models\Enums\ReplyTarget;
use Exception;

class Comment
{
    private int $id;
    private string $content;
    private int|null $owner_id;
    private int|null $reply_to_id;
    private int $post_id;
    private bool $deleted;
    private bool $edited;
    private string $created_at;

    public function __construct()
    {
        $this->id = 0;
        $this->content = "";
        $this->owner_id = null;
        $this->reply_to_id = null;
        $this->post_id = 0;
        $this->deleted = false;
        $this->edited = false;
        $this->created_at = "";
    }

    public function load(int $id): ?Comment
    {
        $pdo = DBConnection::getDB();
        $row = $pdo->query("SELECT * FROM comment WHERE id=$id")->fetch();

        if (!$row) return null;

        $this->id = $row["id"];
        $this->content = $row["content"];
        $this->owner_id = $row['owner_id'];
        $this->reply_to_id = $row["reply_to_id"];
        $this->post_id = $row["post_id"];
        $this->deleted = $row['deleted'];
        $this->edited = $row['edited'];
        $this->created_at = $row["created_at"];
        return $this;
    }

    public function save(): ?Comment
    {
        $pdo = DBConnection::getDB();
        try
        {
            if ($this->id != 0)
            {
                $stmt = $pdo->prepare("UPDATE comment SET content=?,deleted=?,edited=1 WHERE id=?");
                $stmt->execute([$this->content, $this->deleted, $this->id]);
            }
            else
            {
                $stmt = $pdo->prepare("INSERT INTO comment (content, reply_to_id, post_id, owner_id) VALUES (?, ?, ?, ?)");
                $stmt->execute([$this->content, $this->reply_to_id, $this->post_id, $this->owner_id]);
            }

            return $this->load($this->id);
        }
        catch (Exception $e)
        {
            return null;
        }
    }

    public static function getReplies(int $id, ReplyTarget $target = ReplyTarget::COMMENT): array
    {
        $pdo = DBConnection::getDB();
        $comments = [];

        if ($target == ReplyTarget::POST) {
            $stmt = $pdo->query("SELECT * FROM comment WHERE post_id=$id AND reply_to_id IS NULL");
        } else {
            $stmt = $pdo->query("SELECT * FROM comment WHERE reply_to_id=$id");
        }

        while ($row = $stmt->fetch())
        {
            $comments[] = Comment::parseToObject($row);
        }

        return $comments;
    }

    public static function getCount(int $id, ReplyTarget $target = ReplyTarget::COMMENT): int
    {
        $pdo = DBConnection::getDB();

        if ($target == ReplyTarget::POST) {
            $stmt = $pdo->query("SELECT * FROM comment WHERE post_id=$id");
        } else {
            $stmt = $pdo->query("SELECT * FROM comment WHERE reply_to_id=$id");
        }

        return count($stmt->fetchAll());
    }

    public static function parseToObject($row): Comment
    {
        $comment = new Comment();
        $comment->setId($row['id']);
        $comment->setContent($row['content']);
        $comment->setOwnerId($row['owner_id']);
        $comment->setReplyToId($row['reply_to_id']);
        $comment->setPostId($row['post_id']);
        $comment->setDeleted($row['deleted']);
        $comment->setEdited($row['edited']);
        $comment->setCreatedAt($row['created_at']);
        return $comment;
    }

    public function getOwner(): ?User
    {
        return User::fetch($this->owner_id);
    }

    public static function fetch(int $id): ?Comment
    {
        $comment = new Comment();
        return $comment->load($id);
    }

    public static function build(string $content, $post_id, $owner_id, $reply_to_id = null): Comment
    {
        $comment = new Comment();
        $comment->setContent($content);
        $comment->setPostId($post_id);
        $comment->setOwnerId($owner_id);
        $comment->setReplyToId($reply_to_id);
        return $comment;
    }

    public function getLikes(): int
    {
        $pdo = DBConnection::getDB();
        return count($pdo->query("SELECT id FROM comment_like WHERE comment_id = $this->id")->fetchAll());
    }

    #region Getters & Setters
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return int|null
     */
    public function getReplyToId(): int|null
    {
        return $this->reply_to_id;
    }

    /**
     * @return int
     */
    public function getPostId(): int
    {
        return $this->post_id;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @param int|null $reply_to_id
     */
    public function setReplyToId(int|null $reply_to_id): void
    {
        $this->reply_to_id = $reply_to_id;
    }

    /**
     * @param int $post_id
     */
    public function setPostId(int $post_id): void
    {
        $this->post_id = $post_id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param string $created_at
     */
    public function setCreatedAt(string $created_at): void
    {
        $this->created_at = $created_at;
    }

    /**
     * @return int|null
     */
    public function getOwnerId(): int|null
    {
        return $this->owner_id;
    }

    /**
     * @param int|null $owner_id
     */
    public function setOwnerId(int|null $owner_id): void
    {
        $this->owner_id = $owner_id;
    }

    /**
     * @return bool
     */
    public function isDeleted(): bool
    {
        return $this->deleted;
    }

    /**
     * @param bool $deleted
     */
    public function setDeleted(bool $deleted): void
    {
        $this->deleted = $deleted;
    }

    /**
     * @return bool
     */
    public function isEdited(): bool
    {
        return $this->edited;
    }

    /**
     * @param bool $edited
     */
    public function setEdited(bool $edited): void
    {
        $this->edited = $edited;
    }
    #endregion
}