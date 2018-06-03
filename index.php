<?php
    require 'autoloader.php';

    use Service\Task;

    // Test to save a correct and wrong task
    try {
        $task = new Task();
        // First Test
        $task->saveTask(array(
            'done' => False,
            'type' => 'type',
            'content' => 'content',
            'sort_order' => 0,
        ));

        // Second test with empty and/or null values
        // $task->saveTask(array(
        //     'done' => TRUE,
        //     'type' => 'i dont know',
        //     'content' => '',
        //     'sort_order' => null,
        // ));

        $tasks = $task->getTasks();

        // Print and edit all tasks
        foreach ($tasks as $key => $value) {

            echo 'uuid = '. $value[0] .'<br>'.
                 'type = '. $value[1] .'<br>'.
                 'content = '. $value[2] .'<br>'.
                 'sort_order = '. $value[3] .'<br>'.
                 'done = '. $value[4] .'<br>'.
                 'date = '. $value[5] .'<br><br>';

             $task->editTask(array(
                 'done' => TRUE,
                 'type' => 'type edited',
                 'content' => 'edited',
                 'sort_order' => 1,
                 'id' => $value[0]
             ));
        }

        $tasks = $task->getTasks();

        // Print the edited values and remove them
        foreach ($tasks as $key => $value) {

            echo 'uuid editado = '. $value[0] .'<br>'.
                 'type editado = '. $value[1] .'<br>'.
                 'content editado = '. $value[2] .'<br>'.
                 'sort_order editado = '. $value[3] .'<br>'.
                 'done editado = '. $value[4] .'<br>'.
                 'date editado = '. $value[5] .'<br><br>';

           $task->deleteTask($value[0]);
           // $task->deleteTask('');
        }

    } catch (\Exception $e) {
        echo "<pre>". $e->getMessage() ."</pre>";
    }

    $task = null;
