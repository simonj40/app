//create a fighter
echo $this->Form->create('Player');
echo $this->Form->input("id");
echo $this->Form->input("Name");
echo $this->Form->input("Player");
echo $this->Form->input("coordinate_x");
echo $this->Form->input("coordinate_y");
echo $this->Form->input("level");
echo $this->Form->input("xp");
echo $this->Form->input("skill_sight");
echo $this->Form->input("skill_strength");
echo $this->Form->input("skill_health");
echo $this->Form->input("current_health");
echo $this->Form->input("avatar_image");
echo $this->Form->end('Create');