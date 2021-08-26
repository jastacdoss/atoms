<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

trait RestControllerTrait {

    public function index()
    {
        // Instantiate the model
        $model = self::MODEL;

//        // Default filters for the model
//        if (isset($this->defaultFilters) && is_array($this->defaultFilters)) {
//            $model::where($this->defaultFilters);
//        }

        // Fetch the records
        $data = $model::all();

        // Load any relationships
        if (isset($this->loadRelations) && is_array($this->loadRelations)) {
            $data->load($this->loadRelations);
        }

        return $this->successResponse($data);
    }
    public function show($id)
    {
        // Retrieve the model
        $model = self::MODEL;
        if ($data = $model::find($id)) {
            // Load any relationships
            if (isset($this->loadRelations) && is_array($this->loadRelations)) {
                $data->load($this->loadRelations);
            }

            // Use resource if provided
            if (!empty($this->resource)) {
                $data = new $this->resource($data);
            }

            // Return the model
            return $this->successResponse($data);
        }

        // Record not found
        Log::debug('Model not found', [
            'model' => $model,
            'requested_id' => $id,
            'user' => ( !empty(auth()->user()) ? auth()->user()->id : '' )
        ]);
        return $this->notFoundResponse('Unable to locate the ' . ($this->friendlyName ?? 'record'));
    }
    public function store(Request $request)
    {
        // Make sure user is authenticated
        if (empty(auth()->user())) {
            return $this->errorResponse('User is not logged in.');
        }

        // Validate the request
        $model = self::MODEL;

        // Import default values for new model, if set
        $values = isset($this->defaultValues) ? array_merge($this->defaultValues, $request->all()) : $request->all();

        try {
            // Validate the submission
            $v = Validator::make($values, $this->validationRules);

            // Validation fails
            if ($v->fails()) {
                // Log the failure
                Log::debug('Error updating model', [
                    'model' => $model,
                    'changes' => $v->getData(),
                    'user_id' => auth()->user()->id,
                    'request' => $request->all(),
                    'defaults' => $this->defaultValues,
                ]);

                // Throw the exception
                throw new \Exception('ValidationException');
            }

            // Process callbacks
            if (!empty($this->fieldCallbacks)) {
                // Loop through all fields and try callbacks
                foreach ($this->fieldCallbacks as $field => $callback) {
                    // Make sure field is passed
                    if (!empty($values[$field])) {
                        $values[$field] = $callback($values[$field]);
                    }
                }
            }

            // Create the model
            $data = $model::create($values);

            // Load any relationships
            if (isset($this->loadRelations) && is_array($this->loadRelations)) {
                $data->load($this->loadRelations);
            }

            return $this->successResponse($data);
        } catch (\Exception $exception) {
            // Log the exception
            Log::debug('Error updating model', [
                'model' => $model,
                'changes' => $v->getData(),
                'errors' => $v->errors()->toArray(),
                'exception' => $exception->getMessage(),
                'user_id' => auth()->user()->id,
                'request' => $request->all(),
                'defaults' => $this->defaultValues,
            ]);

            // Handle errors
            return $this->errorResponse( 'Unable to create the ' . ($this->friendlyName ?? 'record') . ".\n\r(" . $exception->getMessage() . ')');
        }
    }
    public function validateRequest($values)
    {
        $v = Validator::make($values, $this->validationRules);

        // Validation fails
        if ($v->fails()) {
            // Log the failure
            Log::debug('Error updating model', [
                'model' => self::MODEL,
                'changes' => $v->getData(),
                'user_id' => auth()->user()->id,
                'request' => $values,
                'defaults' => $this->defaultValues,
            ]);
        }
        return $v;
    }

    public function update(Request $request, $id)
    {
        // Make sure user is authenticated
        if (empty(auth()->user())) {
            return $this->errorResponse( 'User is not logged in.');
        }
$a = $request->archive;
        // Retrieve the model instance
        $model = self::MODEL;

        // Fetch values
        $values = $request->all();

        // Make sure model was found
        if(!$data = $model::find($id)) {
            return $this->notFoundResponse();
        }

        try {
            // Validate the submission
            $v = Validator::make($values, $this->validationRules);

            if($v->fails()) {
                // Log the failure
                Log::debug('Error updating model', [
                    'model' => $model,
                    'changes' => $v->getData(),
                    'user_id' => auth()->user()->id,
                    'request' => $request->all()
                ]);
                throw new \Exception("ValidationException");
            }

            // Process callbacks
            if (!empty($this->fieldCallbacks)) {
                // Loop through all fields and try callbacks
                foreach ($this->fieldCallbacks as $field => $callback) {
                    // Make sure field is passed
                    if (!empty($values[$field])) {
                        $values[$field] = $callback($values[$field]);
                    }
                }
            }

            // Update the model
            $data->fill($values);
            $data->save();

            // Load any relationships
            if (isset($this->loadRelations) && is_array($this->loadRelations)) {
                $data->load($this->loadRelations);
            }

            // Use resource if provided
            if (!empty($this->resource)) {
                $data = new $this->resource($data);
            }

            return $this->successResponse($data);
        } catch(\Exception $exception) {
            // Log the exception
            Log::debug('Error updating model', [
                'model' => $model,
                'changes' => $v->getData(),
                'errors' => $v->errors()->toArray(),
                'exception' => $exception->getMessage(),
                'user_id' => auth()->user()->id,
                'request' => $request->all()
            ]);

            // Handle errors
            return $this->errorResponse( 'Unable to update the ' . ($this->friendlyName ?? 'record') . ".\n\r(" . $exception->getMessage() . ')');
        }
    }
    public function destroy($id)
    {
        // Make sure user is authenticated
        if (empty(auth()->user())) {
            return $this->errorResponse( 'User is not logged in.');
        }

        // Retrieve the model instance
        $model = self::MODEL;

        // Unable to delete the model
        if (!$data = $model::find($id)) {
            // Log the failure
            Log::debug('Error deleting model', [
                'model' => $model,
                'id' => $id,
                'user_id' => auth()->user()->id,
            ]);

            return $this->notFoundResponse();
        }

        $data->delete();
        return $this->deleteResponse('Unable to delete the ' . ($this->friendlyName ?? 'record') . '.');
    }
    protected function successResponse($data)
    {
        return response()->json($data, 200);
    }
    protected function notFoundResponse($message = 'Not Found')
    {
        return response()->json($message, 404);
    }
    public function deleteResponse($message = 'Resource Deleted')
    {
        return response()->json($message, 204);
    }
    public function errorResponse($message = 'Unprocessable Entity', $status = 422)
    {
        return response()->json($message, $status);
    }
}
