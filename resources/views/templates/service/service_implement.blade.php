
namespace App\Services\{{$name}};

use App\Repositories\{{ $name }}\I{{ $name  }}Repository;
use App\Services\BaseService;

class {{ $name  }}Service extends BaseService implements I{{ $name  }}Service
{
    public function __construct(private I{{ $name  }}Repository ${{  strtolower($name) }}Repository)
    {
        parent::__construct(${{  strtolower($name) }}Repository);
    }
}
