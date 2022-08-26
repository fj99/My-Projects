<?php

namespace App\Models;

use CodeIgniter\Model;

class Card_model extends Model
{
    protected $table1 = 'cards';
    protected $table2 = 'temp_cards';
    // $this->table1
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect('local');
    }

    public function ShowCards()
    {
        $db = $this->db;

        $builder = $db->table('cards');
        $builder->where('active', 0);
        $query = $builder->get();
        $db->close();

        return $query;
    }

    public function ShowAll()
    {
        $db = $this->db;

        $builder = $db->table('temp_cards');
        $builder->select('*');
        $builder->join('cards', 'temp_cards.id = cards.id', 'right');
        $query = $builder->get();
        $db->close();

        return $query;
    }

    public function insert_temp_card($data, $id)
    {
        $db = $this->db;

        $builder = $db->table('temp_cards');
        $query = $builder->insert($data);
        $query2 = false;

        if ($query) {
            $builder2 = $db->table('cards');
            $builder2->set('active', '1');
            $builder2->where('id', $id);
            $query2 = $builder2->update();
        }
        $db->close();

        return $query and $query2;
    }

    public function insert_card($data)
    {
        $db = $this->db;

        $builder = $db->table('cards');
        $query = $builder->insert($data);
        $db->close();

        return $query;
    }

    public function update_card()
    {
        $db = $this->db;

        $today = date('Y-m-d');

        $builder = $db->table('temp_cards');
        $builder->select('card_id');
        $builder->where('requested_date <', $today);
        $id = $builder->get();
        $query = false;

        foreach ($id->getResult() as $row) {
            $builder2 = $db->table('cards');
            $builder2->set('active', '0');
            $builder2->where('id', $row->card_id);
            $builder2->update();
            $query = $builder2->get();
        }

        $db->close();
        return $query;
    }
}
