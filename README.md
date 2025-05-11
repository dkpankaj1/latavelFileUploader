# latavelFileUploader
use to handle files uploads in laravel 

```bash
use App\Services\FileUploadService;

public function store(Request $request, FileUploadService $uploadService)
{
    $file = $request->file('image');
    $relativePath = $uploadService->upload($file);

    // Save $relativePath to DB if needed
    return response()->json(['path' => $relativePath]);
}
```
