<?php
    require 'autoloader.php';

    use Service\Task;

    $task = new Task();

    // Test to save a correct and wrong task
    try {
        $task->saveTask(array(
            'done' => FALSE,
            'type' => 'i dont know',
            'content' => 'me too',
            'sort_order' => 0,
        ));
        $task->saveTask(array(
            'done' => TRUE,
            'type' => 'i dont know',
            'content' => '',
            'sort_order' => 0,
        ));
    } catch (\Exception $e) {
        echo "<pre>". $e->getMessage() ."</pre>";
    }

    $tasks = $task->getTasks();

    foreach ($tasks as $key => $value) {
        echo 'uuid = '. $value[0]. '<br>';
        echo 'type = '. $value[1]. '<br>';
        echo 'content = '. $value[2]. '<br>';
        echo 'sort_order = '. $value[3]. '<br>';
        echo 'done = '. $value[4]. '<br>';
        echo 'date = '. $value[5]. '<br><br>';
    }

    $task = null;
