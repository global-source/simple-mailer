<?php

/**
 * Simple class to perform customized mailer.
 */
class class_after_listen_email
{

    /**
     * Receiver's Mail.
     * @var bool
     */
    public $to = false;
    /**
     * Sender's Mail.
     * @var bool
     */
    public $from = false;
    /**
     * Mail's Header.
     * @var bool
     */
    public $header = false;
    /**
     * Mail's Subject.
     * @var bool
     */
    public $subject = false;
    /**
     * Mail's Body.
     * @var bool
     */
    public $body = false;
    /**
     * Is this mail have attachment or not.
     * @var bool
     */
    public $have_attachments = false;
    /**
     * This mail's MIME version.
     * @var string
     */
    public $mime_version = "1.0\r\n";
    /**
     * This Mail's Content type.
     * @var string
     */
    public $content_type = "text/html; charset=ISO-8859-1\r\n";
    /**
     * Error list, if this mail have any.
     * @var array
     */
    public $errors = [];

    /**
     * To get all errors, those are throw from this mailer.
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * To push errors to global error object.
     * @param string $type Type of the error.
     * @param string $value Actual value of the error.
     * @return bool True|False.
     */
    public function setErrors($type, $value)
    {
        // Sanity check.
        if (!isset($type)) return false;
        if (!isset($value)) return false;
        $this->errors[$type] = $value;
    }

    /**
     * To get content type.
     * @return string
     */
    public function getContentType()
    {
        // Return content type.
        return $this->content_type;
    }

    /**
     * To set content type of this mail.
     *
     * @param string|bool $content_type
     */
    public function setContentType($content_type = false)
    {
        // Sanity check with the content.
        if (false !== $content_type) $this->content_type = $content_type;
        // If no content type, then use default content type.
        $content_type = 'Content-Type:' . $this->content_type;
        // Push to the header.
        $this->setHeader($content_type);
    }

    /**
     * To get MIME version of this mail.
     *
     * @return string
     */
    public function getMimeVersion()
    {
        return $this->mime_version;
    }

    /**
     * To set MIME version of this mail.
     *
     * @param string|bool $mime_version
     */
    public function setMimeVersion($mime_version = false)
    {
        // Sanity check.
        if (false !== $mime_version) $this->mime_version = $mime_version;
        // If no content type, then use default content type.
        $mime_version = 'MIME-Version:' . $this->mime_version;
        // Push to the header.
        $this->setHeader($mime_version);
    }

    /**
     * @var bool
     */
    protected $attachment = false;

    /**
     * To get the receiver.
     *
     * @return bool
     */
    public function getTo()
    {
        if (false === $this->to) $this->setErrors('To', $this->to);
        return $this->to;
    }

    /**
     * To set the receiver.
     *
     * @param bool $to
     */
    public function setTo($to)
    {
        $this->to = $to;
    }

    /**
     * To get the sender.
     *
     * @return bool
     */
    public function getFrom()
    {
        if (false === $this->from) $this->setErrors('From', $this->from);
        return $this->from;
    }

    /**
     * To set the sender.
     *
     * @param bool $from
     */
    public function setFrom($from)
    {
        $this->from = $from;
        $header = 'From: ' . $this->from;
        $this->setHeader($header);
    }

    /**
     * To get the header.
     *
     * @return bool
     */
    public function getHeader()
    {
        // Sanity check.
        if (false === $this->header) $this->setErrors('Header', $this->header);
        return $this->header;
    }

    /**
     * To set the header.
     *
     * @param bool $header
     * @return bool True|False.
     */
    public function setHeader($header)
    {
        // Sanity check.
        if (!isset($header)) return false;
        // String parse.
        $header = strval($header);
        // Sanity check.
        if (!$header) return false;
        // Push to header.
        $this->header[] = $header;
    }

    /**
     * To get the subject of the mail.
     *
     * @return bool
     */
    public function getSubject()
    {
        // Get with check of the subject.
        if (false === $this->subject) $this->setErrors('Subject', $this->subject);
        return $this->subject;
    }

    /**
     * To set the subject of the mail.
     *
     * @param bool $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * To get body of the mail
     *
     * @return bool
     */
    public function getBody()
    {
        // Get with check of body.
        if (false === $this->body) $this->setErrors('Body', $this->body);
        return $this->body;
    }

    /**
     * To get attachment of this mail.
     *
     * @return bool
     */
    public function getAttachment()
    {
        // Check, whether this mail have attachment or not.
        if (false === $this->isHaveAttachments()) {
            // If doesn't have any attachment, then set "false" to the attachment.
            $this->setAttachment(false);
        }
        // Return attachment.
        return $this->attachment;
    }

    /**
     * To set attachment.
     *
     * @param bool $attachment
     * @return bool True|False.
     */
    public function setAttachment($attachment)
    {
        // Sanity check.
        if (!isset($attachment)) return false;
        $this->attachment = $attachment;
    }

    /**
     * To set body of this mail.
     *
     * @param bool $body
     * @return bool True|False.
     */
    public function setBody($body)
    {
        if (!isset($body)) return false;
        $this->body = $body;
    }

    /**
     * To check, this mail have attachments or not.
     *
     * @return bool
     */
    public function isHaveAttachments()
    {
        return (bool)$this->have_attachments;
    }

    /**
     * To set, this mail have attachment or not.
     *
     * @param bool $have_attachments
     */
    public function haveAttachments($have_attachments)
    {
        $have_attachments = boolval($have_attachments);

        $this->have_attachments = $have_attachments;
    }

    /**
     * To initiating the mailer.
     *
     * @return array|bool
     */
    public function init()
    {
        // Set or update the content type.
        $this->setContentType(false);
        // Set or update MIME type.
        $this->setMimeVersion(false);
        // Initiate mail. if have error, then return those errors.
        return $this->triggerMail();
    }

    /**
     * To send mail by trigger.
     *
     * @return array|bool
     */
    public function triggerMail()
    {
        // Get receiver.
        $to = $this->getTo();
        // Get subject.
        $title = $this->getSubject();
        // Get body.
        $body = $this->getBody();
        // Get header.
        $header = $this->getHeader();
        // Get attachment.
        $attachment = $this->getAttachment();
        // Check if error occurred, then throw error list back.
        if (count($this->getErrors()) > 0) return $this->getErrors();
        // trigger mail.
        wp_mail($to, $title, $body, $header, $attachment);
        return true;
    }

}
