<?php
function insertTutoringRequest($pdo, $studentId, $data) {
    $stmt=$pdo->prepare('INSERT INTO tutoring_requests(student_id,course,topic,preferred_date,preferred_time) VALUES(?,?,?,?,?)');
    $stmt->execute([$studentId,$data['course'],$data['topic'],$data['preferred_date'],$data['preferred_time']]);
    return (int)$pdo->lastInsertId();
}
function findRequest($pdo, $id, $owner = null) {
    $sql='SELECT r.*,s.student_name,s.student_email FROM tutoring_requests r JOIN students s ON r.student_id=s.student_id WHERE r.request_id=?'; $args=[$id]; if($owner!==null){$sql.=' AND s.user_id=?';$args[]=$owner;} $stmt=$pdo->prepare($sql);
    $stmt->execute($args);return $stmt->fetch();
}
function listRequests($pdo, $course = '', $status = '', $owner = null) {
    $sql='SELECT r.*,s.student_name FROM tutoring_requests r JOIN students s ON r.student_id=s.student_id WHERE 1=1';$args=[];
    if($course!==''){$sql.=' AND r.course = ?';$args[]=$course;}
    if($status!==''){$sql.=' AND r.status = ?';$args[]=$status;}
    if($owner!==null){$sql.=' AND s.user_id=?';$args[]=$owner;}
    $sql.=' ORDER BY r.request_id DESC';$stmt=$pdo->prepare($sql);$stmt->execute($args);return $stmt->fetchAll();
}
function updateOpenRequest($pdo, $id, $data, $owner=null) {
    $sql="UPDATE tutoring_requests SET course=?,topic=?,preferred_date=?,preferred_time=? WHERE request_id=? AND status='Open'"; $args=[$data['course'],$data['topic'],$data['preferred_date'],$data['preferred_time'],$id]; if($owner!==null){$sql.=" AND student_id IN (SELECT student_id FROM students WHERE user_id=?)";$args[]=$owner;} $stmt=$pdo->prepare($sql);
    $stmt->execute($args);return $stmt->rowCount()===1;
}
function cancelOpenRequest($pdo, $id, $owner=null) {
    $sql="UPDATE tutoring_requests SET status='Cancelled' WHERE request_id=? AND status='Open'";$args=[$id];if($owner!==null){$sql.=" AND student_id IN (SELECT student_id FROM students WHERE user_id=?)";$args[]=$owner;}$stmt=$pdo->prepare($sql);
    $stmt->execute($args);return $stmt->rowCount()===1;
}
