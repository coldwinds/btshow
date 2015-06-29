# Introduction #

Default user rights table (in default\_settings.php)

You can change this settings in local\_settings.php in the root directory.

# Details #

## rights-roles granting ##
| rights     \     roles | `*`     | user  | confirmed | uploader | teamleader | sysop | developer | description |
|:-----------------------|:--------|:------|:----------|:---------|:-----------|:------|:----------|:------------|
| page-view              | any     |       |           |          |            |       |           | view any page |
| page-create            |         |       |           | any      |            |       |           | create a page |
| page-modify            |         |       |           | own,team |            | any   |           | edit one's own page |
| page-delete            |         |       |           | own,team |            | any   |           | delete/undelete one's own page |
| page-delete-purge      |         |       |           |          |            |       | any       | delete any page from database |
| page-star              |         |       |           |          |            | any   |           | star any page (so we can put it on top) |
| page-rate              | any     |       |           |          |            |       |           | give scores to rate any page |
| page-nocomment         |         |       |           | own      |            |       |           | deny/allow comment posting of one's own page |
| comment-view           | any     |       |           |          |            |       |           | view comments of any page |
| comment-viewip         |         |       |           |          |            | any   |           | view ip of the poster in a comment header |
| comment-post           | any     |       |           |          |            |       |           | post a comment of any page |
| comment-delete         |         |       |           |          |            | any   |           | delete/undelete one's own comment of any page |
| comment-delete-purge   |         |       |           |          |            |       | any       | delete any comment of any page from database |
| controlled-vocabulary  |         |       |           |          |            | any   |           | maintain the controlled vocabulary |
| team-membership        |         |       |           |          | own        | any   |           | add/remove a user to/from his own team |
| team-name              |         |       |           |          | own        | any   |           | set his own team's name and code |
| user-login             |         | own   |           |          |            |       |           | can login   |
| user-skipcaptcha       |         |       | own       |          |            |       |           | skip captcha validation when posting |
| user-rights            |         |       |           |          |            | any   |           | set user's role |
| user-delete            |         | own   |           |          |            | any   |           | account suicide |
| user-delete-purge      |         |       |           |          |            |       | any       | delete any account from database |
| cache-clear            |         |       |           |          |            |       | any       | force to clear server's cache of file |

  * **rights**
  1. page-view: If you want your site to be private, change this.
  1. page-modify: Comments of the page are not affected (whether the page is deleted). Note that an account can be used to clear out the contents of a page without delete it.
  1. page-delete: As you can undelete, you will always see deleted pages.
  1. page-star: If you'd like to put some pages above other pages.
  1. page-rate: Rating flood prohibition is built-in functionality.
  1. page-nocomment: Who have this rights are not affected by this.
  1. team-membership: When a user is added to teamleader, a team is created. When the leader is removed from the team, the team is dismissed (internally just marked as dismissed). When a new leader is assigned to the team, the old leader is retired and asked to select to stay as team member or to quit. One team has only one leader at one time. One account has only one team.
  1. team-`*`: How do I create a team? Add yourself to teamleader to create a team, then change the teamleader to someone and quit this team.
  1. team-`*`: It's not a good idea to grant these rights to a sysop for him interfering with a team's internal affairs.
  1. user-login: By default, an account such as a sysop not in user can't login.
  1. user-delete: Since you have suicided, you are not a user that can login or undelete your account. If you want to recover you account, you can ask a sysop for help.
  1. `*`-delete-purge: Permanently delete data from database. Other deletes only mark data as deleted.
  * **roles**
  1. `*`: Anyone, including anonymous browser
  1. user: Registered people
  1. confirmed: Validated user. when an account is added to uploader, teamleader, or sysop, he is auto-confirmed.
  * **ownership check when applying rights**
  1. **Note:** What can a object be? they are: page, comment, team, user, and cache.
  1. any: No check, rights apply to anyone's owning objects.
  1. own: rights only apply to your own owning objects.
  1. team: rights apply to your team's owning objects.

## typical account kinds ##
| `*`     | user  | confirmed | uploader | teamleader | sysop | rights |
|:--------|:------|:----------|:---------|:-----------|:------|:-------|
| in      |       |           |          |            |       |        |
| in      | in    |           |          |            |       |        |
| in      | in    | in        |          |            |       |        |
| in      | in    | in        | in       | in         |       |        |
| in      | in    | in        | in       |            | in    |        |
| in      | in    | in        | in       | in         | in    | (usually bad idea) |

## API ##
```
class user {
	public function judge($action, $object_owner_id = false, $object_owningteam_id = false); // return: (bool)
	public function get_id();
	public function get_team_id();
	function __construct(){
		$this->groups=$this->get_usergroup();
		foreach($sg_default_groups as $default_group)
		// order is important! order of group leads to overwriting of rights!
			if($this->group[$default_group]===true) 
			// if this account is in the `$default_group` group
				foreach($this->rights as $right=>$type) 
				//all local rights inherit their value from `$default_group` group
				//one by one, orderly!
					if($this->rights[$right]=$sg_default_rights[$default_group][$right]);
		//all proper rights are inherited
}}
```