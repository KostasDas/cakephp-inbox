

<?php

echo $this->Html->css([
    'dataTables/datatables.min',
    'protocol'
]);
echo $this->Flash->render();
?>

<section class="section">
    <h3 class="title is-4 card-footer-item">Εργασίες</h3>
    <form class="form-horizontal box"">
    <div class="columns">
        <?php if ($isAdmin) :?>
        <div class="column">
            <div class="select is-dark is-fullwidth">
                <select id="s_user"
                        data-live-search="true"
                        title="Χειριστής">
                    <option value="">Όλοι οι χειριστές</option>
                </select>
            </div>
        </div>
        <?php endif; ?>
        <div class="column">
            <div class="select is-dark is-fullwidth">
                <select id="s_read"
                        data-live-search="true"
                        title="Επιλέξτε κατάσταση εργασίας">
                    <option value="">Όλες οι εργασίες</option>
                    <option value="0">Μη διαβασμένες εργασίες</option>
                    <option value="1">Διαβασμένες εργασίες</option>
                </select>
            </div>
        </div>
        <div class="column">
            <div class="select is-dark is-fullwidth">
                <select id="s_done"
                        data-live-search="true"
                        title="Επιλέξτε κατάσταση εργασίας">
                    <option selected="selected" value="0">Τρεχουσες εργασίες</option>
                    <option value="1">Ολοκληρομένες εργασίες</option>
                </select>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="columns">
        <div class="column is-one-third is-block">
            <label for="s_due" class="label">Προθεσμία εώς:</label>
            <input id="s_due" class="is-dark input" type="date">
        </div>
    </div>
    </form>
</section>

<div class="columns is-block-widescreen">
    <table id="protocolTable" class="table table-hover table-dark text-center"></table>
</div>

<?php


echo $this->Html->script([
    'dataTables/datatables.min',
    'tasks',
    'dateFunctions',
]);

?>
