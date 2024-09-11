namespace App\Http\Controllers\Admin;

use App\Contracts\Services\{{ ucfirst($name) }}ServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\Attributes\CategoryAttributes;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class {{ ucfirst($name) }}Controller extends Controller
{
    private {{ ucfirst($name) }}ServiceInterface $service;

    public function __construct({{ ucfirst($name) }}ServiceInterface $service)
    {
        $this->service = $service;
    }

    public function show()
    {
        return view('admin.{{ strtolower($name) }}.index')->with([
            'buttons' => [
                [
                    'label' => 'Add New',
                    'url' => route('{{ strtolower($name) }}-add'),
                    'icon' => 'ti-plus'
                ],
            ],
            'headers' => [
                'Name',
                'Status',
                'Action'
            ],
        ]);
    }

    public function add()
    {
        return view('admin.{{ strtolower($name) }}.add')->with([]);
    }

    public function create(CategoryRequest $request)
    {
        $request['status'] = $request->input('status') === 'on' ? Category::STATUS_ACTIVE : Category::STATUS_INACTIVE;

        ${{ strtolower($name) }}Attributes = (new CategoryAttributes());
        $data = ${{ strtolower($name) }}Attributes->updateDataRequest((new Category())->getFillable(), $request)->toArray();

        $response = $this->service->create($data);

        if ($response) {
            return redirect()->route('{{ strtolower($name) }}-view')->with('success', 'Category added successfully.');
        }

        return redirect()->back()->with('error', 'Failed to upload file. Please try again.');
    }

    public function edit($id)
    {
        $response = $this->service->getById($id);

        return view('admin.{{ strtolower($name) }}.edit')->with([
            'data' => $response,
        ]);
    }

    public function update(UpdateCategoryRequest $request)
    {
        $request['status'] = $request->input('status') === 'on' ? Category::STATUS_ACTIVE : Category::STATUS_INACTIVE;

        ${{ strtolower($name) }}Attributes = (new CategoryAttributes());
        $data = ${{ strtolower($name) }}Attributes->updateDataRequest((new Category())->getFillable(), $request)->toArray();

        $response = $this->service->update($request['id'], $data);

        if ($response) {
            return redirect()->route('{{ strtolower($name) }}-view')->with('success', 'Occupation update successfully.');
        }

        return redirect()->back()->with('error', 'Failed to upload file. Please try again.');
    }

    public function list(Request $request)
    {
        return $this->service->dataTableList($request);
    }

    public function delete(Request $request)
    {
        $data = $this->service->delete($request->input('id'));

        if ($data) {
            return response()->json([
                'message' => 'Notice delete successfully',
                'status_code' => ResponseAlias::HTTP_OK,
                'data' => []
            ], ResponseAlias::HTTP_OK);
        }

        return response()->json([
            'message' => 'Notice delete successfully',
            'status_code' => ResponseAlias::HTTP_BAD_REQUEST,
            'data' => []
        ], ResponseAlias::HTTP_BAD_REQUEST);
    }

}
