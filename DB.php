<?php
require 'db/connect.php';

require 'includes/background.php';
$pageTitle = 'Dexter Fimoser DataBase';
require 'includes/header.php';
?>

<script src="db/db.js"></script>

<div class="LeftObject">
    <!-- Form for adding a record -->
     <p>Додати користувача</p>
    <form method="post">
        <input type="text" name="login" placeholder="Логін" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <button type="submit" name="add"><i class="fa-solid fa-square-plus icon"></i>Додати</button>
    </form>
    
     <!-- Accounts table -->
    <div class="table-wrapper">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Ім'я Користувача</th>
                <th>Пароль</th>
                <th>Час останнього оновлення</th>
                <th>Дія</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['user_id'] ?></td>
                    <td><?= htmlspecialchars($row['login']) ?></td>
                    <td><?= str_repeat('*', max(6, $row['password_length'])); ?></td>
                    <td><?= $row['time_update'] ?></td>
                    <td>
                        <!-- Actions -->
                        <div class="actions">
                            <a href="#" onclick="toggleEditRow(<?= $row['user_id'] ?>)"><i class="fa-solid fa-pen-to-square icon"></i>Редагувати</a>
                            <a href="?delete=<?= $row['user_id'] ?>" onclick="return confirm('Ви впевненні? Видалені дані неможливо відновити')"><i class="fa-solid fa-trash icon"></i>Видалити</a>
                        </div>
                    </td>
                </tr>
                <tr id="edit-row-<?= $row['user_id'] ?>" class="edit-row" style="display: none;">
                    <td colspan="5">
                        <form method="post">
                            <input type="hidden" name="user_id" value="<?= $row['user_id'] ?>">
                            <input type="text" name="login" value="<?= htmlspecialchars($row['login']) ?>" required>
                            <input type="password" name="old_password" placeholder="Пароль" required>
                            <input type="password" name="password" placeholder="Новий Пароль" required>
                            <button type="submit" name="save_edit" onclick="hideEditRow(<?= $row['user_id'] ?>)"><i class="fa-solid fa-check icon"></i>Зберегти</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    </div>
</div>

</body>
</html>

<?php
$connect->close();
?>