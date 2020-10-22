<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Question</title>
</head>
<body>
    <?php

    require 'connection.php';

    // Creating / selecting database
    $db=$conn->queBank;

    // Create / select collection
    $collection=$db->questions;

    ?>
    <!-- Add New Question --> 
    <table id="addQueForm" align="center" class="shadow pl-3 table table-borderless card addQueForm" style="background:#e8f1f8;"> 
        <form action="submitQue.php" method="post" id="addQue">
            <tr>
                <td>
                    <label class="font-weight-bold" for="que_type">Select Question Type : </label>
                </td>
                <td>
                    <select required id="que_type" name="que_type">
                        <option value="" disabled selected hidden>Question Type</option>
                        <!-- Value="" is important to add in disabled option without which required function doesn't work -->
                        <!-- Reference : https://www.w3docs.com/snippets/css/how-to-create-a-placeholder-for-an-html5-select-box-by-using-only-html-and-css.html -->

                        <option value="Quantitative">Quantitative</option>
                        <option value="General Knowledge">General Knowledge</option>
                        <option value="Logical">Logical</option>
                        <option value="Verbal">Verbal</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <label class="font-weight-bold" for="que_title">Add Question Title : </label>
                </td>
                <td>
                    <textarea required rows="1" cols="100" name="title" id="que_title" type="text" placeholder="Question Title"></textarea>
                </td>
            </tr>
            <tr>
                <td>
                    <label class="font-weight-bold" for="que_body">Add Question : </label>
                </td>
                <td>
                    <textarea required rows="3" cols="100" name="body" id="que_body" type="text" placeholder="Question Body"></textarea>
                </td>
            </tr>
            <tr>
                <td>
                    <label class="font-weight-bold" for="optionA">Option A : </label>
                </td>
                <td>
                    <textarea required rows="1" cols="100" name="optionA" id="optionA" type="text" placeholder="Option A"></textarea>
                </td>
            </tr><tr>
                <td>
                    <label class="font-weight-bold" for="optionB">Option B : </label>
                </td>
                <td>
                    <textarea required rows="1" cols="100" name="optionB" id="optionB" type="text" placeholder="Option B"></textarea>
                </td>
            </tr><tr>
                <td>
                    <label class="font-weight-bold" for="optionC">Option C : </label>
                </td>
                <td>
                    <textarea required rows="1" cols="100" name="optionC" id="optionC" type="text" placeholder="Option C"></textarea>
                </td>
            </tr><tr>
                <td>
                    <label class="font-weight-bold" for="optionD">Option D : </label>
                </td>
                <td>
                    <textarea required rows="1" cols="100" name="optionD" id="optionD" type="text" placeholder="Option D"></textarea>
                </td>
            </tr>
            <tr>
                <td>
                    <label class="font-weight-bold" for="answer">Select Correct Option : </label>
                </td>
                <td>
                    <select required name="answer" id="answer">
                    <option value="" disabled selected hidden>Correct Option</option>
                        <!-- Reference : https://www.w3docs.com/snippets/css/how-to-create-a-placeholder-for-an-html5-select-box-by-using-only-html-and-css.html -->

                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <label class="font-weight-bold" for="marks">Question Marks : </label>
                </td>
                <td>
                    <input required name="marks" id="marks" type="number" placeholder="Maximum Marks">
                </td>
            </tr>
            <tr><td colspan="2" align="center">
                <button style="width:90%;padding:10px;" class="btn btn-info font-weight-bold" form="addQue">Add Question</button>
            </td></tr>
        </form>
    </table>
</body>
</html>