<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Constraint\Count;

class MessController extends Controller
{
    // GO TO Messagerie
    public function messagerie(){
        if(check_session() =='no')
            return redirect('/'); 
        reresh_perssion(session()->get('user'), request()->url());
        return return_view_after_check_read("layouts2.messagerie");
        //return view("layouts.configuration");
        //dd(session()->get('permission'));
    }
    
    // GETS USERS
    public function get_users(){
        if(check_session() =='no')
            return redirect('/'); 
        
        $sql = DB::select("SELECT DISTINCT (employes.code), employes.image, employes.nom, employes.prenom
            FROM employes, messages 
            WHERE NOT employes.code =? 
            AND ( (messages.emp_sender = ? AND employes.code = messages.emp_getter ) 
            OR (messages.emp_getter = ?  AND employes.code = messages.emp_sender ) ) GROUP BY employes.code 
ORDER BY MAX(messages.id) DESC", [session()->get('user')->code_user, session()->get('user')->code_user, session()->get('user')->code_user]);
        
        $output = "";
        if(count($sql) == 0){
            //$output .= "Pas d'utilisateurs";
            $output .= '<div class="col-sm-12 col-xs-12 sideBar-avatar">Pas d\'utilisateurs</div>';
        }elseif(count($sql) > 0){
            
            foreach($sql as $row){
                $sql2 = DB::select("SELECT * from messages WHERE (emp_sender = ? OR emp_getter=?) AND ( emp_sender = ? OR emp_getter = ? ) ORDER BY messages.id  DESC LIMIT 1", [$row->code, $row->code, session()->get('user')->code_user, session()->get('user')->code_user]);
                
                
                (count($sql2) > 0) ? $result = $sql2[0]->message : $result ="Aucun message";
                (strlen($result) > 49) ? $msg =  substr($result, 0, 49) . '...' : $msg = $result;
                if(isset($sql2[0]->emp_sender)){
                    ($sql2[0]->emp_sender == session()->get('user')->code_user) ? $you = "Vous: " : $you = "Lui: ";
                }else{
                    $you = "Lui: ";
                }
                /*($row['status'] == "Offline now") ? $offline = "offline" : $offline = "";
                ($outgoing_id == $row['unique_id']) ? $hid_me = "hide" : $hid_me = "";*/
        
                $stylestatut = "";
                if ( $sql2[0]->lecture == 0 && $sql2[0]->emp_getter == session()->get('user')->code_user) {
                   $stylestatut = 'style=" color:green"';
                }
               
                $output .= '<a href="/messagerie/messagerie/chat/'. $row->code .'">
                            <div class="content">
                            <img src="'.print_image_emp($row->code, $row->image).'" alt="">
                            <div class="details">
                                <span>'. $row->prenom. " " . $row->nom .'</span>
                                <p '.$stylestatut.'>'. $you . $msg .'</p>
                            </div>
                            </div>
                            <!--div class="status-dot '. "offline" .'"><i class="fas fa-circle"></i></div-->
                        </a>';
                
                /*$output .= '
                <div class="col-sm-3 col-xs-3 sideBar-avatar">
                    <a href="/messagerie/user/'.$row->code.'">
                    <div class="avatar-icon">
                    <img src="/storage/employes/'.$row->code.'/'. $row->image .'" alt="">
                </div>
            </div>
            <div class="col-sm-9 col-xs-9 sideBar-main">
                <div class="row">
                    <div class="col-sm-8 col-xs-8 sideBar-title">
                        <span class="name-meta">'. $row->prenom.'</span>
                    </div>
                    <div class="col-sm-4 col-xs-4 pull-right sideBar-title">
                        <span class="time-meta pull-right">18:18</span>
                    </div>
                    <div class="col-sm-8 col-xs-8 sideBar-title">
                        <span class="name-meta">'. $you . $msg .'</span>
                    </div>
                </div>
                </a>
            </div>';*/
            }
        }
        echo $output;
        
    }

    public function search_user($val){
        $outgoing_id = session()->get('user')->code_user;

        $sql = DB::select("SELECT * FROM employes WHERE NOT code = ? AND ( prenom LIKE ? OR nom LIKE ? )", [$outgoing_id , "%{$val}%", "%{$val}%" ]);
        $output = "";
        
        $output = "";
        if(count($sql) == 0){
            //$output .= "Pas d'utilisateurs";
            $output .= '<div class="col-sm-12 col-xs-12 sideBar-avatar">Pas d\'utilisateur</div>';
        }elseif(count($sql) > 0){
            //include_once "data.php";

            foreach($sql as $row){
                $sql2 = DB::select("SELECT * from messages WHERE (emp_sender = ? OR emp_getter=?) AND ( emp_sender = ? OR emp_getter = ? ) ORDER BY messages.id  DESC LIMIT 1", [$row->code, $row->code, session()->get('user')->code_user, session()->get('user')->code_user]);
                
                (count($sql2) > 0) ? $result = $sql2[0]->message : $result ="Aucun message";
                (strlen($result) > 49) ? $msg =  substr($result, 0, 49) . '...' : $msg = $result;
                if(isset($sql2[0]->emp_sender)){
                    ($sql2[0]->emp_sender == session()->get('user')->code_user) ? $you = "Vous: " : $you = "";
                }else{
                    $you = "";
                }
                
                /*($row['status'] == "Offline now") ? $offline = "offline" : $offline = "";
                ($outgoing_id == $row['unique_id']) ? $hid_me = "hide" : $hid_me = "";*/
        
                $output .= '<a href="/messagerie/messagerie/chat/'. $row->code .'">
                            <div class="content">
                            <img src="'.print_image_emp($row->code, $row->image).'" alt="">
                            <div class="details">
                                <span>'. $row->prenom. " " . $row->nom .'</span>
                                <p>'. $you . $msg .'</p>
                            </div>
                            </div>
                            <!--div class="status-dot '. "offline" .'"><i class="fas fa-circle"></i></div-->
                        </a>';
                
                /*$output .= '
                <div class="col-sm-3 col-xs-3 sideBar-avatar">
                    <a href="/messagerie/user/'.$row->code.'">
                        <div class="avatar-icon">
                            <img src="/storage/employes/'.$row->code.'/'. $row->image .'" alt="">
                        </div>
                        </div>
                    <div class="col-sm-9 col-xs-9 sideBar-main">
                        <div class="row">
                            <div class="col-sm-8 col-xs-8 sideBar-title">
                                <span class="name-meta">'. $row->prenom.'</span>
                            </div>
                            <div class="col-sm-4 col-xs-4 pull-right sideBar-title">
                                <span class="time-meta pull-right">18:18</span>
                            </div>
                            <div class="col-sm-8 col-xs-8 sideBar-title">
                                <span class="name-meta">'. $you . $msg .'</span>
                            </div>
                        </div>
                    </a>
            </div>';*/
            }
        }
        echo $output;
    }

    
    public function chat_with($val){
        if(check_session() =='no')
            return redirect('/'); 

        $sql = DB::select("SELECT employes.* FROM employes WHERE employes.code =?", [$val]);
        reresh_perssion(session()->get('user'), request()->url());
        return return_view_after_check_read("layouts2.messageriechat")->with('other_user', $sql[0]);
    }

    public function inserer_message(Request $request){
        if(check_session() =='no')
            return redirect('/'); 

        
        $outgoing_id = session()->get('user')->code_user;
        $incoming_id = $request->incoming_id;
        $message = $request->message;
        if(!empty($message)){
            //$sql = mysqli_query($conn, "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg) VALUES ({$incoming_id}, {$outgoing_id}, '{$message}')") or die();
            $sql = new Message();
            $sql->emp_sender = $outgoing_id;
            $sql->emp_getter = $incoming_id;
            $sql->message = $message;
            $sql->lecture = 0;
            $sql->save();

        }
        
    }

    public function get_chat(Request $request){

        $outgoing_id = session()->get('user')->code_user;
        $incoming_id = $request->incoming_id;
        $output = "";
        $sql = DB::select("SELECT DISTINCT(messages.id), messages.* FROM employes, messages WHERE code = emp_sender OR code = emp_getter AND (code = ? OR code = ?) order BY messages.id", [$incoming_id, $outgoing_id]);

        if(count($sql) > 0){
            foreach($sql as $row){
                if($row->emp_sender=== $outgoing_id){
                    $output .= '<div class="chat outgoing">
                                <div class="details">
                                    <p>'. $row->message .'</p>
                                </div>
                                </div>';
                }else{
                    $output .= '<div class="chat incoming">
                                <div class="details">
                                    <p>'. $row->message  .'</p>
                                </div>
                                </div>';
                }
                // <img src="php/images/'.$row['img'].'" alt="">
            }
        }else{
            $output .= '<div class="text">Aucun message envoyé.</div>';
        }
        echo $output;
        
    }

    public function get_chat2($val){

        $outgoing_id = session()->get('user')->code_user;
        $incoming_id = $val;
        $output = "";
        $sql = DB::select("SELECT DISTINCT(messages.id), messages.* FROM messages WHERE (emp_sender = ? AND emp_getter = ?) OR (emp_sender = ? AND emp_getter = ?) order BY messages.id", [$incoming_id, $outgoing_id, $outgoing_id, $incoming_id]);
        /*
         SELECT * FROM messages LEFT JOIN employes ON employes.code = messages.emp_sender
         WHERE (emp_sender = {$outgoing_id} AND emp_getter = {$incoming_id})
         OR (emp_sender = {$incoming_id} AND emp_getter = {$outgoing_id}) ORDER BY messages.id
         */
        
        if(count($sql) > 0){
            foreach($sql as $row){
                if($row->emp_sender=== $outgoing_id){
                    $output .= '<div class="chat outgoing">
                                <div class="details">
                                    <p>'. $row->message .'</p>
                                </div>
                                </div>';
                }else{
                    $output .= '<div class="chat incoming">
                                <div class="details">
                                    <p>'. $row->message  .'</p>
                                </div>
                                </div>';
                }
                // <img src="php/images/'.$row['img'].'" alt="">
            }

            if($row->emp_getter=== $outgoing_id){
                $upd = DB::update("UPDATE messages SET lecture = 1 WHERE emp_sender = ? AND emp_getter = ?", [$row->emp_sender, $row->emp_getter]);
            }
        }else{
            $output .= '<div class="text">Débutez la discussion !</div>';
        }
        echo $output;
        
    }
}