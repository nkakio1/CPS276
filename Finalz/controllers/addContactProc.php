<?php
$sticky = new StickyForm();
$msg = "";

$config = [
    'masterStatus' => ['error' => false],
    'fname'   => ['id'=>'fname', 'name'=>'fname', 'type'=>'text', 'label'=>'First Name', 'required'=>true, 'value'=>'', 'regex'=>'name', 'errorMsg'=>'Name must be alpha characters only.'],
    'lname'   => ['id'=>'lname', 'name'=>'lname', 'type'=>'text', 'label'=>'Last Name', 'required'=>true, 'value'=>'', 'regex'=>'name', 'errorMsg'=>'Name must be alpha characters only.'],
    'address' => ['id'=>'address', 'name'=>'address', 'type'=>'text', 'label'=>'Address', 'required'=>true, 'value'=>'', 'regex'=>'address', 'errorMsg'=>'Address must start with a number followed by street name.'],
    'city'    => ['id'=>'city', 'name'=>'city', 'type'=>'text', 'label'=>'City', 'required'=>true, 'value'=>'', 'regex'=>'city', 'errorMsg'=>'City must be alpha characters only.'],
    'state'   => ['id'=>'state', 'name'=>'state', 'type'=>'select', 'label'=>'State', 'required'=>true, 'selected'=>'', 'regex'=>'state', 'options'=>[
        ''=>'Select State', 'Michigan'=>'Michigan', 'Ohio'=>'Ohio', 'California'=>'California', 'Texas'=>'Texas', 'Florida'=>'Florida'
    ]],
    'phone'   => ['id'=>'phone', 'name'=>'phone', 'type'=>'text', 'label'=>'Phone', 'required'=>true, 'value'=>'', 'regex'=>'phone', 'errorMsg'=>'Phone must be in format 999.999.9999', 'placeholder'=>'999.999.9999'],
    'email'   => ['id'=>'email', 'name'=>'email', 'type'=>'text', 'label'=>'Email', 'required'=>true, 'value'=>'', 'regex'=>'email', 'errorMsg'=>'Invalid email address.'],
    'dob'     => ['id'=>'dob', 'name'=>'dob', 'type'=>'text', 'label'=>'Date of Birth', 'required'=>true, 'value'=>'', 'regex'=>'date', 'errorMsg'=>'Date of Birth must be mm/dd/yyyy', 'placeholder'=>'mm/dd/yyyy'],
    'age'     => ['id'=>'age', 'name'=>'age', 'type'=>'radio', 'label'=>'Choose an Age Range', 'required'=>true, 'regex'=>'age', 'errorMsg'=>'You must select an age range', 'options'=>[
        ['value'=>'0-17', 'label'=>'0-17', 'checked'=>false],
        ['value'=>'18-30', 'label'=>'18-30', 'checked'=>false],
        ['value'=>'30-50', 'label'=>'30-50', 'checked'=>false],
        ['value'=>'50+', 'label'=>'50+', 'checked'=>false]
    ]],
    'contacts'=> ['id'=>'contacts', 'name'=>'contacts', 'type'=>'checkbox', 'label'=>'Select One or More Options', 'required'=>false, 'options'=>[
        ['value'=>'newsletter', 'label'=>'newsletter', 'checked'=>false],
        ['value'=>'email', 'label'=>'email', 'checked'=>false],
        ['value'=>'text', 'label'=>'text', 'checked'=>false]
    ]]
];

if(isset($_POST['addContact'])){
    $config = $sticky->validateForm($_POST, $config);
    if(!isset($_POST['age'])){
        $config['age']['error'] = "You must select an age range";
        $config['masterStatus']['error'] = true;
    }

    if($config['masterStatus']['error'] == false){
        
        $contactsArr = [];
        if(isset($_POST['contacts'])){
             foreach($_POST['contacts'] as $opt){
                 $contactsArr[] = $opt;
             }
        }
        $contactsStr = empty($contactsArr) ? "No choices selected" : implode(", ", $contactsArr);

        $sql = "INSERT INTO contacts (fname, lname, address, city, state, phone, email, dob, contacts, age) 
                VALUES (:fname, :lname, :address, :city, :state, :phone, :email, :dob, :contacts, :age)";
        $bindings = [
            [':fname', $config['fname']['value'], 'str'],
            [':lname', $config['lname']['value'], 'str'],
            [':address', $config['address']['value'], 'str'],
            [':city', $config['city']['value'], 'str'],
            [':state', $config['state']['selected'], 'str'],
            [':phone', $config['phone']['value'], 'str'],
            [':email', $config['email']['value'], 'str'],
            [':dob', $config['dob']['value'], 'str'],
            [':contacts', $contactsStr, 'str'],
            [':age', $_POST['age'], 'str']
        ];
        $pdo = new PdoMethods();
        $result = $pdo->otherBinded($sql, $bindings);

        if($result == 'noerror'){
            $msg = "<p>Contact Information Added</p>";
            foreach($config as $k => &$v){
                if($k == 'masterStatus') continue;
                if(isset($v['value'])) $v['value'] = '';
                if(isset($v['selected'])) $v['selected'] = '';
                if(isset($v['options'])){
                    foreach($v['options'] as &$opt){
                        if(is_array($opt)) $opt['checked'] = false;
                    }
                }
            }
        } else {
            $msg = "<p>There was an error adding the record</p>";
        }
    }
}
?>