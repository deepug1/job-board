<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\JobRequest;
use App\Models\Job;

class MyJobController extends Controller
{

    public function index()
    {
         return view(
            'my_job.index',
            [
                'jobs' => auth()->user()->employer
                    ->jobs()
                    ->with(['employer', 'jobApplications', 'jobApplications.user'])
                    ->get()
            ]
        );
    }

  
    public function create()
    {
         return view('my_job.create');
    }

  
    public function store(JobRequest $request)
    {
           auth()->user()->employer->jobs()->create($request->validated());
           return redirect()->route('my-jobs.index')
            ->with('success', 'Job created successfully.');
    }



    public function edit(Job $myJob)
    {
          return view('my_job.edit', ['job' => $myJob]);
    }

 
    public function update(JobRequest $request, Job $myJob)
    {
         $myJob->update($request->validated());

        return redirect()->route('my-jobs.index')
            ->with('success', 'Job updated successfully.');
    }

 
    public function destroy(string $id)
    {
        //
    }
}