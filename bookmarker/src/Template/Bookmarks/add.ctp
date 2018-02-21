<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Bookmark $bookmark
 */
 
	public function add()
	{
		$bookmark = $this->Bookmarks->newEntity();
		if ($this->request->is('post')) {
			$bookmark = $this->Bookmarks->patchEntity($bookmark, $this->request->getData());
			$bookmark->user_id = $this->Auth->user('id');
			if ($this->Bookmarks->save($bookmark)) {
				$this->Flash->success('The bookmark has been saved.');
				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error('The bookmark could not be saved. Please, try again.');
		}
		$tags = $this->Bookmarks->Tags->find('list');
		$this->set(compact('bookmark', 'tags'));
	}
	
	public function edit($id = null)
	{
		$bookmark = $this->Bookmarks->get($id, [
			'contain' => ['Tags']
		]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$bookmark = $this->Bookmarks->patchEntity($bookmark, $this->request->getData());
			$bookmark->user_id = $this->Auth->user('id');
			if ($this->Bookmarks->save($bookmark)) {
				$this->Flash->success('The bookmark has been saved.');
				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error('The bookmark could not be saved. Please, try again.');
		}
		$tags = $this->Bookmarks->Tags->find('list');
		$this->set(compact('bookmark', 'tags'));
	}
 
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Bookmarks'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Tags'), ['controller' => 'Tags', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Tag'), ['controller' => 'Tags', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="bookmarks form large-9 medium-8 columns content">
    <?= $this->Form->create($bookmark) ?>
    <fieldset>
        <legend><?= __('Add Bookmark') ?></legend>
        <?php
            echo $this->Form->control('user_id', ['options' => $users]);
            echo $this->Form->control('title');
            echo $this->Form->control('description');
            echo $this->Form->control('url');
            echo $this->Form->control($this->Form->input('tag_string', ['type' => 'text']), ['options' => $tags]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
