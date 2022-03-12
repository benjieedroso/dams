<?php
class ArchiveModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function archive_file_db($data)
    {
        date_default_timezone_set("Asia/Manila");
        $date = date("Y-m-d g:i:s:A");
        $this->db->query(
            "INSERT INTO uploads (file_name, file_type, file_tmpName, file_error, file_size, file_date, file_path) VALUES ( :fileName, :fileType, :fileTmpName, :fileError, :fileSize, :fileDate, :filePath)"
        );
        for ($i = 0; $i < count($data["file_name"]); $i++) {
            $this->db->bind(":fileName", $data["file_name"][$i]);
            $this->db->bind(":fileType", $data["file_type"][$i]);
            $this->db->bind(":fileTmpName", $data["file_tmp_name"][$i]);
            $this->db->bind(":fileError", $data["file_error"][$i]);
            $this->db->bind(":fileSize", $data["file_size"][$i]);
            $this->db->bind(":fileDate", $date);
            $this->db->bind(":filePath", $data["root_path"] .$data["folder_name"]. "\\" . $data["file_name"][$i]);
            $this->db->execute();
        }
    }

    public function select_all_files()
    {
        $this->db->query("SELECT * FROM uploads");
        $this->db->execute();

        return $this->db->resultSet();
    }

    public function display_data_from_db()
    {
        $this->db->query("SELECT * FROM uploads");
        $this->db->execute();

        return $this->db->resultSet();
    }

    public function sort($data)
    {
        if ($data === "alpha") {
            $this->db->query("SELECT * FROM uploads ORDER BY file_name ASC;");
            $this->db->execute();
        } else if ($data === "id") {
            $this->db->query("SELECT * FROM uploads ORDER BY file_id ASC;");
            $this->db->execute();
        } else if ($data === "date") {
            $this->db->query("SELECT * FROM uploads ORDER BY file_date ASC;");
            $this->db->execute();
        }

        return $this->db->resultSet();
    }
}