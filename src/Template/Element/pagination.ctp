<div class="col-xs-12 text-center">
    <nav class="pagination justify-content-center top-0 bottom-30">
        <ul class="pagination">
            <li class="page-item disabled">
                <?= $this->Paginator->first(__('Primeiro'), ['class' => 'paginate_button', 'tag' => 'li', 'escape' => false]); ?>
            </li>

            <li class="page-item">
                <?= $this->Paginator->numbers(['class' => 'paginate_button', 'separator' => '', 'tag' => 'li', 'currentLink' => true, 'currentClass' => 'active', 'currentTag' => 'a','modulus' => 4]); ?>
            </li>

            <li class="page-item">
                <?= $this->Paginator->last(__('Último'), ['class' => 'paginate_button', 'escape' => false]); ?>
            </li>
        </ul>
    </nav>
</div>