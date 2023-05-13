<?php

namespace App\Models;

use CodeIgniter\Model;

class Card_model extends Model
{
    protected $cards = 'cards';
    protected $table2 = 'temp_cards';
    protected $db;

    // public function __construct()
    // {
    //     $this->db = \Config\Database::connect('default');
    // }

    public function ShowCards()
    {
        $db = $this->db;

        $builder = $db->table('cards');
        $builder->where('active', 0);
        $query = $builder->get();
        $db->close();

        return $query;
    }

    public function Cards_taken()
    {
        $db = $this->db;

        $builder = $db->table('cards');
        $builder->where('active', 1);
        $query = $builder->get();
        $db->close();

        return $query;
    }
    
    public function All_Cards()
    {
        $db = $this->db;

        $builder = $db->table('cards');
        $query = $builder->get();
        $db->close();

        return $query;
    }

    public function ShowAll()
    {
        $db = $this->db;

        $builder = $db->table('temp_cards');
        $builder->select('*');
        $builder->join('cards', 'temp_cards.card_id = cards.id', 'left');
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
        $table = $this->cards;
        $builder = $db->table($table);
        $builder->where("card_number", $data["card_number"]);        
        $query = $builder->get();
        $check = $query->getNumRows();
        if($check<0){
            $query = $builder->insert($data);
            $db->close();
            return $query;
        }else{
            $db->close();
            return false;
        }
    }

    public function update_card()
    {
        $db = $this->db;
        $today = date('Y-m-d');

        $builder = $db->table('temp_cards');
        $builder->select('card_number', 'administrator');
        $builder->join('cards', 'temp_cards.card_id = cards.id', 'left');
        $builder->where('requested_date <', $today);
        $query = $builder->get();

        $dee = "dahlmand1@southernct.edu";
        $minaya = "minayac1@southernct.edu";
        $palak = "patelp22@southernct.edu";

        $email = \Config\Services::email();

        foreach ($query->getResult() as $row) {
            // $name = $row->administrator;
            if ($row->administrator = "dee") {
                $to = "dahlmand1@southernct.edu";
            } elseif ($row->administrator = "christian") {
                $to = "minayac1@southernct.edu";
            } elseif ($row->administrator = "palak") {
                $to = "patelp22@southernct.edu";
            }

            $email->setFrom('Reslife@southernct.edu', 'Reslife');
            // $email->setTo('Fernandezf2@southernct.edu');
            $email->setTo($to);
            $email->setCC($dee);
            $email->setSubject('Temporary Id expires');
            $email->setMessage('This temporary ID was due today the card number is' . $row->card_number);

            $email->send();
        }

        $db->close();
    }

    public function return_card($data)
    {
        $db = $this->db;
        $date = date('Y-m-d');
        $check = true;
        $data2 = [
            'returned_date' => $date,
        ];

        $builder = $db->table('temp_cards');
        $builder->where("card_id", $data);
        $builder->where("returned_date", null);
        $builder->update($data2);

        $data3 = [
            "active" => 0,
        ];

        $builder2 = $db->table('cards');
        $builder2->where("id", $data);
        $builder2->update($data3);

        $db->close();
        return $check;
    }
}
