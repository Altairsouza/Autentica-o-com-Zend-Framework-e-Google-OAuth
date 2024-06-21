<?php

require_once __DIR__ . '/../db/Conexao.php';
class Application_Model_Crud
{
    protected $dbAdapter;
    protected $banco = 'crud';

    public function __construct()
    {
        $settingsModel = new Conexao();
        $this->dbAdapter = $settingsModel->getDbAdapter();
    }


    public function create($data)
    {
        $this->dbAdapter->insert($this->banco, $data);
        return $this->dbAdapter->lastInsertId();
    }

    public function readAll()
    {
        $select = $this->dbAdapter->select()
            ->from($this->banco);
        return $this->dbAdapter->fetchAll($select);
    }

    public function update($id, $data)
    {
        return $this->dbAdapter->update($this->banco, $data, 'id = ' . (int)$id);
    }

    public function delete($id)
    {
        return $this->dbAdapter->delete($this->banco, 'id = ' . (int)$id);
    }

    public function read($id)
    {
        $select = $this->dbAdapter->select()
            ->from($this->banco)
            ->where('id = ?', $id);

        return $this->dbAdapter->fetchRow($select);
    }
}
