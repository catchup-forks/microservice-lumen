<?php

	namespace App\Api\v1;

	use App\Api\v1\ApiBaseController;
	use App\Repositories\PostRepository as Post;
	use Illuminate\Http\Request;

	/**
	 * Post resource representation.
	 *
	 * @Resource("Posts", uri="/posts")
	 */
	class PostController extends ApiBaseController
	{
		/**
		 * @var Actor
		 */
		private $post;

		public function __construct(Post $post)
		{

			$this->post = $post;
		}

		/**
		 * Display a listing of resource.
		 *
		 * Get a JSON representation of all posts.
		 *
		 * @Get("/posts")
		 * @Versions({"v1"})
		 * @Response(200, body={"id":1,"user_id":6,"status":"{\"status\": \"active\"}","title":"Dolore quis...","description":"Expedita et quam ..","deleted_at":null})
		 */
		public function index()
		{
			$posts = $this->post->all();
			return $this->response->array($posts->toArray());
		}

		/**
		 * Show specific post
		 *
		 * Get a JSON representation of the post.
		 *
		 * @Get("/posts/{id}")
		 * @Versions({"v1"})
		 * @Request({"id": "1"})
		 * @Response(200, body={"id":1,"user_id":6,"status":"{\"status\": \"active\"}","title":"Dolore quis...","description":"Expedita et quam ..","deleted_at":null})
		 */
		public function show($id)
		{
			$post = $this->post->find($id);
			if ($post) {
				return $this->response->array($post->toArray());
			}
			return $this->error("notFound");
		}

		public function create() {}

		/**
		 * Create a new post
		 *
		 * Get a JSON representation of new post.
		 *
		 * @Get("/users/{id}")
		 * @Versions({"v1"})
		 * @Request(body={email":"lavonne.cole@hermann.com","name":"Amelie Trantow","surname":"Kayley Klocko Sr."})
		 * @Response(200, success or error)
		 */
		public function store(Request $request)
		{
			$task = $this->post->create(['user_id' => 1, 'status' => '{}', 'title' => 'exe', 'description' => 'exe']);
			if ($task) {
				return $this->success("created");
			}
			return $this->error("internal");
		}

		public function edit($id) {}


		/**
		 * Update post
		 *
		 * Get a JSON representation of updatepost.
		 *
		 * @Get("/users/{id}")
		 * @Versions({"v1"})
		 * @Request(array -> {email":"lavonne.cole@hermann.com","name":"Amelie Trantow","surname":"Kayley Klocko Sr."}, id)
		 * @Response(200, success or error)
		 */
		public function update(Request $request, $id)
		{
			$task = $this->post->update(['user_id' => 1, 'status' => '{}', 'title' => 'exe', 'description' => 'exe'], $id);
			if ($task) {
				return $this->success("updated");
			}
			return $this->error("notFound");
		}

		/**
		 * Delete a post
		 *
		 * Get a JSON representation of delete post.
		 *
		 * @Get("/users/{id}")
		 * @Versions({"v1"})
		 * @Request(id)
		 * @Response(200, success or error)
		 */
		public function delete($id)
		{
			if ($this->post->find($id)) {
				$task = $this->post->delete($id);

				if($task)
					return $this->success("deleted");

				return $this->error("internal");
			}
			return $this->error("notFound");
		}
	}
