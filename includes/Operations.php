<?php
class Operations
{
    private $con;
    private $db;
    public $file;
    public $tbform = 'form',
        $tbtheme = 'theme',
        $tbresponses = 'responses',
        $tboptions = 'options',
        $tbusers = 'users',
        $tbquestions = 'questions',
        $tbStud = 'students',
        $createdby,
        $modified,
        $modifiedby,
        $created,
        $user_id,
        $form_id,
        $title,
        $Fullname,
        $StudentID,
        $Firstname,
        $Lastname,
        $DateOfBirth,    $Gender,    $Address,    $ContactNumber,
        $username,
        $Email,
        $Password,
        $subscription_id;


    function __construct()
    {
        require_once dirname(__FILE__) . './Connect.php';

        $this->db = new Connect();

        $this->con = $this->db->connect();
    }

    // create a user
    public function createUsers()
    {
        if (!$this->isTheUserExisting()) {
            $query = $this->con->prepare(
                'INSERT INTO ' .
                    $this->tbusers .
                    '(Email,Password,Fullname) VALUES (?,?,?)'
            );

            // sanitize incoming input
            $this->Email = $this->sanitizeInput(
                'User email',
                $this->Email,
                'STRING'
            );
            $this->Password = $this->sanitizeInput(
                'Password',
                $this->Password,
                'STRING'
            );

            $this->Fullname = $this->sanitizeInput(
                'Your Full Names',
                $this->Fullname,
                'STRING'
            );

            $query->bind_param(
                'sss',
                $this->Email,
                $this->Password,
                $this->Fullname,
            );
            if ($query->execute()) {
                return USER_CREATED;
            } else {
                return USER_CREATION_FAILED;
            }
        } else {
            return USER_EXISTS;
        }
    }

    // function to check if the USER exists
    public function isTheUserExisting()
    {
        $query = $this->con->prepare(
            'SELECT Fullname FROM ' .
                $this->tbusers .
                ' WHERE Fullname = ? OR Email = ?'
        );
        // sanitize input
        $this->Fullname = $this->sanitizeInput(
            'Full Name',
            $this->Fullname,
            'STRING'
        );
        $this->Email = $this->sanitizeInput(
            'User Email',
            $this->Email,
            'STRING'
        );

        $query->bind_param('ss', $this->Fullname, $this->Email);
        $query->execute();
        $query->store_result();
        return $query->num_rows > 0;
    }

    // getall users
    public function retrieveAllUsers()
    {
        $query = $this->con->prepare(
            'SELECT user_id,username,email,password_hash,subscription_id,other_user_attributes,created,created_by,modified,modified_by FROM ' .
                $this->tbusers
        );
        $query->execute();
        $query->bind_result(
            $user_id,
            $username,
            $email,
            $password_hash,
            $subscription_id,
            $other_user_attributes,
            $created,
            $created_by,
            $modified,
            $modified_by
        );
        $query->store_result();
        $users = [];
        $sn = 0;
        if ($query->num_rows > 0) {
            while ($query->fetch()) {
                $sn = $sn + 1;
                $user = [];
                $user['sn'] = $sn;
                $user['user_id'] = $user_id;
                $user['username'] = $username;
                $user['email'] = $email;
                $user['password_hash'] = $password_hash;
                $user['subscription_id'] = $subscription_id;
                $user['other_user_attributes'] = $other_user_attributes;
                $user['created'] = $created;
                $user['createdby'] = $created_by;
                $user['modified'] = $modified;
                $user['modifiedby'] = $modified_by;


                array_push($users, $user);
            }
            return $users;
        } else {
            return 'No Users found';
        }
    }


    public function userLogin()
    {
        $stmt = $this->con->prepare(
            'SELECT * FROM  ' .
                $this->tbusers  .
                ' WHERE Email = ? AND Password = ?'
        );
        //sanitize incoming data
        $this->Email = $this->sanitizeInput('User Email', $this->Email, 'STRING');
        $this->Password = $this->sanitizeInput(
            'User Password',
            $this->Password,
            'STRING'
        );
        $stmt->bind_param('ss', $this->Email, $this->Password);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            return USER_AUTHENTICATED;
        } else {
            return USER_AUTHENTICATION_FAILED;
        }
    }


    // student
    public function createStudent()
    {
        if (!$this->isStudentExisting()) {
            $query = $this->con->prepare(
                'INSERT INTO ' .
                    $this->tbStud .
                    '(Firstname,Lastname,DateOfBirth,Gender,Address,ContactNumber,Email,created,createdby) VALUES (?,?,?,?,?,?,?,?,?)'
            );

            // sanitize incoming input
            $this->Firstname = $this->sanitizeInput(
                'Your FirstName',
                $this->Firstname,
                'STRING'
            );
            $this->Lastname = $this->sanitizeInput(
                'Your LastName',
                $this->Lastname,
                'STRING'
            );
            $this->DateOfBirth = $this->sanitizeInput(
                'Date Of Birth',
                $this->DateOfBirth,
                'STRING'
            );
            $this->Gender = $this->sanitizeInput(
                'Gender',
                $this->Gender,
                'STRING'
            );
            $this->Address = $this->sanitizeInput(
                'Address',
                $this->Address,
                'STRING'
            );
            $this->ContactNumber = $this->sanitizeInput(
                'Contact',
                $this->ContactNumber,
                'INTEGER'
            );
            $this->Email = $this->sanitizeInput(
                'Email Address',
                $this->Email,
                'STRING'
            );
            $this->created = $this->sanitizeInput(
                'Created On',
                $this->created,
                'STRING'
            );
            $this->createdby = $this->sanitizeInput(
                'Created By',
                $this->createdby,
                'INTEGER'
            );

            $query->bind_param(
                'ssssssssi',
                $this->Firstname,
                $this->Lastname,
                $this->DateOfBirth,
                $this->Gender,
                $this->Address,
                $this->ContactNumber,
                $this->Email,
                $this->created,
                $this->createdby
            );
            if ($query->execute()) {
                return STUDENT_CREATED;
            } else {
                return STUDENT_CREATE_FAILED;
            }
        } else {
            return STUDENT_EXISTS;
        }
    }

    // all students
    public function isStudentExisting()
    {
        $query = $this->con->prepare(
            'SELECT ContactNumber FROM ' .
                $this->tbStud .
                ' WHERE ContactNumber = ? AND Email = ?'
        );
        // sanitize input
        $this->ContactNumber = $this->sanitizeInput(
            'COntact',
            $this->ContactNumber,
            'STRING'
        );
        $this->Email = $this->sanitizeInput(
            'Student Email',
            $this->Email,
            'STRING'
        );

        $query->bind_param('ss', $this->ContactNumber, $this->Email);
        $query->execute();
        $query->store_result();
        return $query->num_rows > 0;
    }

    //function to get all students
    public function retrieveAllStudents()
    {
        $query = $this->con->prepare(
            'SELECT StudentID,Firstname,Lastname,DateOfBirth,Gender,Address,ContactNumber,Email,created,createdby,modifiedby,modified FROM ' .
                $this->tbStud
        );
        $query->execute();
        $query->bind_result(
            $StudentID,
            $Firstname,
            $Lastname,
            $DateOfBirth,
            $Gender,
            $Address,
            $ContactNumber,
            $Email,
            $created,
            $createdby,
            $modifiedby,
            $modified
        );
        $query->store_result();
        $students = [];
        $sn = 0;
        if ($query->num_rows > 0) {
            while ($query->fetch()) {
                $sn = $sn + 1;
                $student = [];
                $student['sn'] = $sn;
                $student['StudentID'] = $StudentID;
                $student['Firstname'] = $Firstname;
                $student['Lastname'] = $Lastname;
                $student['DateOfBirth'] = $DateOfBirth;
                $student['Gender'] = $Gender;
                $student['Address'] = $Address;
                $student['ContactNumber'] = $ContactNumber;
                $student['Email'] = $Email;
                $student['created'] = $created;
                $student['createdBy'] = $createdby;
                $student['modifiedBy'] = $modifiedby;
                $student['modified'] = $modified;

                array_push($students, $student);
            }
            return $students;
        } else {
            return 'No Students found';
        }
    }

    public function getDateandTime()
    {
        date_default_timezone_set('Africa/Kampala');
        return date('y/m/d h:i:sa');
    }


    public function getAdminIDByEmail($Email)
    {
        $stmt = $this->con->prepare(
            'SELECT UserID  FROM users WHERE Email = ? '
        );
        $username = $this->sanitizeInput('Username.', $Email, 'STRING');
        $stmt->bind_param('s', $Email);
        $stmt->execute();
        $stmt->bind_result($id);
        $stmt->fetch();

        return $id;
    }

    // function to delete students
    public function deleteStudent()
    {
        $query = $this->con->prepare('DELETE FROM students WHERE  StudentID = ?');
        //sanitize id coming
        $this->StudentID = $this->sanitizeInput(
            'Student Id',
            $this->StudentID,
            'INTEGER'
        );
        $query->bind_param('i', $this->StudentID);
        if ($query->execute()) {
            return STUDENT_DELETED;
        } else {
            return STUDENT_DELETION_FAILED;
        }
    }

    // public function updateStudent()
    // {
    //     $query = $this->con->prepare(
    //         'UPDATE students SET FirstName = ?, LastName = ?,DateOfBirth = ?,gender=?,email = ?,Address = ?,ContactNumber = ?,modifiedby = ?,modified = ? WHERE StudentID = ? '
    //     );
    //     //sanitize incoming data
    //     $this->FirstName = $this->sanitizeInput(
    //         'First Name',
    //         $this->FirstName,
    //         'STRING'
    //     );
    //     $this->LastName = $this->sanitizeInput(
    //         'Last Name',
    //         $this->LastName,
    //         'STRING'
    //     );
    //     $this->DateOfBirth = $this->sanitizeInput(
    //         'Date Of Birth',
    //         $this->DateOfBirth,
    //         'STRING'
    //     );
    //     $this->gender = $this->sanitizeInput(
    //         'Password',
    //         $this->gender,
    //         'STRING'
    //     );
    //     $this->Email = $this->sanitizeInput(
    //         'Registration No',
    //         $this->Email,
    //         'STRING'
    //     );
    //     $this->ContactNumber = $this->sanitizeInput(
    //         'Contact',
    //         $this->ContactNumber,
    //         'INTEGER'
    //     );
    //     $this->modifiedBy = $this->sanitizeInput(
    //         'Modified By',
    //         $this->modifiedBy,
    //         'INTEGER'
    //     );
    //     $this->modified = $this->sanitizeInput(
    //         'Modified On',
    //         $this->modified,
    //         'STRING'
    //     );
    //     $this->StudentID = $this->sanitizeInput(
    //         'Student Id',
    //         $this->StudentID,
    //         'INTEGER'
    //     );

    //     $query->bind_param(
    //         'sssssiisi',
    //         $this->Firstname,
    //         $this->Lastname,
    //         $this->DateOfBirth,
    //         $this->email,
    //         $this->password,
    //         $this->regno,
    //         $this->ContactNumber,
    //         $this->modifiedBy,
    //         $this->modified,
    //         $this->ID
    //     );

    //     if ($query->execute()) {
    //         return STUDENT_UPDATED;
    //     } else {
    //         return STUDENT_UPDATE_FAILED;
    //     }
    // }
    // function to update users
    // public function updateUser()
    // {
    //     $query = $this->con->prepare(
    //         'UPDATE users SET username = ?, email = ?,subscription_id = ?,other_user_attributes=?,modified = ?,modified_by = ? WHERE user_id = ? '
    //     );

    //     //sanitize incoming data
    //     $this->username = $this->sanitizeInput(
    //         'Username',
    //         $this->username,
    //         'STRING'
    //     );
    //     $this->email = $this->sanitizeInput(
    //         'User Email',
    //         $this->email,
    //         'STRING'
    //     );
    //     $this->subscription_id = $this->sanitizeInput(
    //         'Subscription',
    //         $this->subscription_id,
    //         'INTEGER'
    //     );
    //     $this->other_user_attributes = $this->sanitizeInput(
    //         'Others',
    //         $this->other_user_attributes,
    //         'STRING'
    //     );
    //     $this->modified = $this->sanitizeInput(
    //         'Modified On',
    //         $this->modified,
    //         'STRING'
    //     );
    //     $this->modified_by = $this->sanitizeInput(
    //         'Modified By',
    //         $this->modified_by,
    //         'INTEGER'
    //     );

    //     $this->user_id = $this->sanitizeInput(
    //         'User Id',
    //         $this->user_id,
    //         'INTEGER'
    //     );

    //     $query->bind_param(
    //         'ssissii',
    //         $this->username,
    //         $this->email,
    //         $this->subscription_id,
    //         $this->other_user_attributes,
    //         $this->modified,
    //         $this->modified_by,
    //         $this->user_id
    //     );

    //     if ($query->execute()) {
    //         return USER_UPDATED;
    //     } else {
    //         return USER_UPDATE_FAILED;
    //     }
    // }

    // get user id using an email
    // public function getUserIdByEmail()
    // {
    //     $stmt = $this->con->prepare('SELECT user_id FROM users WHERE email = ? ');
    //     $this->email = $this->sanitizeInput(
    //         'Username.',
    //         $this->email,
    //         'STRING'
    //     );
    //     $stmt->bind_param('s', $this->email);
    //     $stmt->execute();
    //     $stmt->bind_result($id);
    //     $stmt->fetch();

    //     return $id;
    // }

    // function for gettign a user by id
    // public function getUserUsingId()
    // {
    //     $query = $this->con->prepare(
    //         'SELECT user_id, username, email,subscription_id,other_user_attributes,created,created_by,modified, modified_by FROM users WHERE user_id = ? '
    //     );
    //     $this->user_id = $this->sanitizeInput(
    //         'User Id',
    //         $this->user_id,
    //         'INTEGER'
    //     );
    //     $query->bind_param('i', $this->user_id);
    //     $query->execute();
    //     $query->bind_result(
    //         $user_id,
    //         $username,
    //         $email,
    //         $subscription_id,
    //         $other_user_attributes,
    //         $created,
    //         $created_by,
    //         $modified,
    //         $modified_by

    //     );
    //     $query->store_result();
    //     $query->fetch();

    //     $user = [];
    //     $user['user_id'] = $user_id;
    //     $user['username'] = $username;
    //     $user['email'] = $email;
    //     $user['subscription_id'] = $subscription_id;
    //     $user[' other_user_attributes'] = $other_user_attributes;
    //     return $user;
    // }

    // function to delete user
    // public function deleteUser()
    // {
    //     $query = $this->con->prepare('DELETE FROM users WHERE user_id = ?');

    //     //sanitize id coming
    //     $this->user_id = $this->sanitizeInput(
    //         'User Id',
    //         $this->user_id,
    //         'INTEGER'
    //     );
    //     $query->bind_param('i', $this->user_id);
    //     if ($query->execute()) {
    //         return USER_DELETED;
    //     } else {
    //         return USER_DELETION_FAILED;
    //     }
    // }


    //Check empty fields
    public function sanitizeInput(
        $fieldName,
        $value,
        $dataType,
        $required = true
    ) {
        if ($required && empty($value)) {
            echo "$fieldName is a required field.\n";
            exit();
        }

        switch ($dataType) {
            case 'BOOLEAN':
                if (!is_bool($value)) {
                    echo "$fieldName field has an invalid data type. It should be boolean.\n";
                    return;
                }
                break;
            case 'INTEGER':
                if (!is_numeric($value)) {
                    echo "$fieldName field has an invalid data type. It should be numeric.";
                    return;
                }
                break;
            case 'STRING':
                if (!is_string($value)) {
                    echo "$fieldName field has an invalid data type. It should be a string.";
                    return;
                }
                break;
            default:
                echo "$fieldName field has an invalid data type.";
                return;
        }
        $value = htmlspecialchars(strip_tags($value));
        return htmlspecialchars(strip_tags($value));
    }
}
