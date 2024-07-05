<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use App\Models\JobApplication;
use App\Http\Requests\JobRequest;
// use Illuminate\Foundation\Auth\User;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class MyJobController extends Controller
{

    public function index()
    {
         $this->authorize('viewAnyEmployer', Job::class);
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
          $this->authorize('create', Job::class);
         return view('my_job.create');
    }

  
    public function store(JobRequest $request)
    {
         $this->authorize('create', Job::class);
           auth()->user()->employer->jobs()->create($request->validated());
           return redirect()->route('my-jobs.index')
            ->with('success', 'Job created successfully.');
    }



    public function edit(Job $myJob)
    {
         $this->authorize('update', $myJob);
          return view('my_job.edit', ['job' => $myJob]);
    }

 
    public function update(JobRequest $request, Job $myJob)
    {
         $this->authorize('update', $myJob);
         $myJob->update($request->validated());

        return redirect()->route('my-jobs.index')
            ->with('success', 'Job updated successfully.');
    }

    public function downloadCV(Job $myJob, User $user)
    {
        // Find the job application by ID
        $jobApplication = JobApplication::where('job_id', $myJob->id)->where('user_id', $user->id)->firstOrFail();
        // dd($jobApplication);
 
        //Check if the job application has CV
        if (!$jobApplication->cv_path) {
            return redirect()->route('my-jobs.index')
                ->with('error', 'This job application does not have a CV.');
        }
        //Check if the employer of the job application is the same as the logged in user
        if ($myJob->employer->id !== auth()->user()->employer->id) {
            return redirect()->route('my-jobs.index')
                ->with('error', 'You do not have permission to download this CV.');
        }

        // Check if the file exists on the private disk
        if (!Storage::disk('private')->exists($jobApplication->cv_path)) {
            return redirect()->route('my-jobs.index')
                ->with('error', 'This CV file does not exist.');
        }

        // Return the file as a download response
        return Storage::disk('private')->download($jobApplication->cv_path);

    }

}