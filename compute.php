<?php
include 'includes/DB.php';
include 'helper/Response.php';
class compute
{
public static function instance(){
    return new compute();
}



public function fetch($sql,$array = true, $return = false, $dataName="Records")
{
    $result = DB::instance() ->execute($sql);

    if (!$result) {


        if($return){
            return false;
        }else{
           $this->display(null,false,"Not found");
        }
    }else{
        if($result->num_rows > 0){
            if ($array) {
                while ($row = $result->fetch_assoc()) {
                    $newArray[] = $row;
                }

                if ($return) {
                    return $newArray;
                }else{
                    compute::instance() ->display(array($dataName => $newArray));
                }
            }else{
                if ($return) {
                    return $result -> fetch_assoc();
                }else{
                    compute::instance() ->display(array($dataName => $result));
                }
            }
        }
        else{
            if ($return){
                return null;
            }else{
                compute::instance() ->display(null, false,"Not found");
            }
        }
    }
}


public function execute($sql, $return = false)
{
    $result = DB::instance() ->execute($sql);
    if ($result) {
        if ($return) {
            return $result;
        }
        else{
            compute::instance()->display();
        }
    }
    else{
        if ($return) {
            return false;
        }else{
            compute::instance()->display($result, false, "failed");
        }
    }
}

public function display($data = null, $success = true, $message = "Success", $STATUS_SUCCESS = \helper\Response::STATUS_SUCCESS )
{
    $response = new \helper\Response();
    $response->status = $STATUS_SUCCESS;
    $response->message = $message;
    $response->success = $success;
    $response->data = $data;
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
}