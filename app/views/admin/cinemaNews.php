<h1>Opret nyhed</h1>

<form method="post" action="?url=admin/cinemaNews/create" class="admin-form">
    <div class="form-group">
        <label for="title">Overskrift</label>
        <input type="text" id="title" name="title" required>
    </div>


    <div class="form-group">
        <label for="body">Indhold</label>
        <textarea id="body" name="content" rows="6" required></textarea>
    </div>



    <button type="submit" class="btn btn--primary">Opret nyhed</button>
</form>

<h1>Nyheder</h1>

<?php if (!empty($news)): ?>
    <div class="list">
        <?php foreach ($news as $item): ?>
            <div class="row">
                <div>
                    <strong><?= e($item['title']) ?></strong><br>
                    <small>
                        <?= !empty($item['published_date']) ? date('d.m.Y', strtotime($item['published_date'])) : '' ?>
                    </small>
                </div>

                <div>
                    <form method="post" action="?url=admin/cinemaNews/delete" onsubmit="return confirm('Slet nyhed?');"> <input type="hidden" name="newsID" value="<?= (int)$item['newsID'] ?>">
                        <button type="submit" class="btn btn--ghost">Slet</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>Der er endnu ingen nyheder.</p>
<?php endif; ?>