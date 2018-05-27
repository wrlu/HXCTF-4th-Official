<?php

// create table session(
//     session_id char(32) not null primary key,
//     ip varchar(30),
//     data varchar(100)
// );

class session
{

    function __construct(&$db, $session_id='', $session_table = 'session', $session_name='SESSID')
    {
        $this->dbConn  = $db;
        $this->session_name = $session_name;
        $this->session_table = $session_table;
        $this->_ip = $this->real_ip();


        //第一步，将$_COOKIE中的session值放到this->session_id中，注意可能为空
        if ($session_id == '' && !empty($_COOKIE[$this->session_name]))
        {
            $this->session_id = $_COOKIE[$this->session_name];
        }
        else
        {
            $this->session_id = $session_id;
        }

        //基于前面的操作，除了正确格式的session值，其余都已经置为空了，现在将session为空的进行从新的session分配并记录到数据库中
        if ($this->session_id)
        {
            $this->load_session();
        }
        else
        {
            $this->gen_session_id();

            setcookie($this->session_name, $this->session_id);
        }

    }

    //对于新的访问，设置其session值，并将一个预定的session变量序列化后存放到数据库里
    function insert_session()
    {
        //INSERT INTO session (session_id, ip, data) VALUES ('$this->session_id', '$this->_ip', 'a:2:{s:4:\"name\xxxx";s:5:\"gue;}')
        return $this->dbConn->query('INSERT INTO ' . $this->session_table . " (session_id, ip, data) VALUES ('" . $this->session_id ."', '". $this->_ip ."', 'a:2:{s:4:\"name\";s:5:\"guest\";s:5:\"score\";s:1:\"0\";}')");
    }

    //确定session_id可用后，从数据库中提取出来data并反序列化成$_SESSION对象
    function load_session()
    {
        //SELECT data FROM session WHERE session_id = '$this->session_id' and ip = '$this->_ip'
        $res = $this->dbConn->query('SELECT data FROM ' . $this->session_table . " WHERE session_id = '" . $this->session_id . "'");
        $session = $res->fetch_array();
        if (empty($session))
        {
            $this->insert_session();
        }
        else
        {
            $GLOBALS['_SESSION']  = unserialize($session['data']);
        }
    }

    //有时候需要对session进行修改，而不是简单的读取数据，就要记得将其序列化后保存起来
    function update_session()
    {
        $data = serialize($GLOBALS['_SESSION']);

        $data = addslashes($data);

        return $this->dbConn->query('UPDATE ' . $this->session_table . " SET ip = '" . $this->_ip . "',  data = '$data' WHERE session_id = '" . $this->session_id . "'");
    }

    function gen_session_id()
    {
        $this->session_id = md5(uniqid(mt_rand(), true));

        return $this->insert_session();
    }

    function gen_session_key($session_id)
    {
        static $ip = '';

        if ($ip == '')
        {
            $ip = substr($this->_ip, 0, strrpos($this->_ip, '.'));
        }

        return sprintf('%08x', crc32($ip . $session_id));
    }

    function real_ip()
    {
        static $realip = NULL;

        if ($realip !== NULL)
        {
            return $realip;
        }

        if (isset($_SERVER))
        {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            {
                $realip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
            elseif (isset($_SERVER['HTTP_CLIENT_IP']))
            {
                $realip = $_SERVER['HTTP_CLIENT_IP'];
            }
            else
            {
                if (isset($_SERVER['REMOTE_ADDR']))
                {
                    $realip = $_SERVER['REMOTE_ADDR'];
                }
                else
                {
                    $realip = '0.0.0.0';
                }
            }
        }
        else
        {
            $realip = '0.0.0.0';
        }
        return $realip;
    }

}
