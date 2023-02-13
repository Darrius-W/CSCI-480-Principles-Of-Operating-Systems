/********************************************************************
CSCI 480 - Assignment 4 - Fall/2022

Progammer: Darrius White(z1900146)
Section:   Y01
Date Due:  11/06/2022

Purpose:   Program is an implementation for the Readers Writers
	   problem. The amount of Reader/Writer threads are taken
	   from std input and the appropriate amount of reader/writer
	   threads are created. Each thread then gets sent over to
	   thier destination function where they will either read the
	   data contained in a global string or write and remove the
	   last character from the string using semaphores where
	   appropriate to limit writers from writing when there are
	   readers reading, as well as to protect the updating of the
	   readcount.

*********************************************************************/
/*Need to change directory: z1900146_project4_dir
  Need to change filename: z1900146_project4
  Need to create makefile*/
#include <pthread.h>
#include <stdio.h>
#include <stdlib.h>
#include <semaphore.h>
#include <unistd.h>
#include <string.h>

// Declare Semaphores/RC/String
sem_t mutex, rw_sem;
int rc;
char str[] = "Hello Earthlings!";


/*Write Process responsible for removing last character
  from string when allowed by semaphore.*/
void *wrtProcess(void *param){

  //some local variables
  int size; // determing size of string
  long tid;
  tid = (long)param; // holds the thread id


  //loop until the string is empty
  do{
    //If string is empty leave loop
    if(strlen(str) == 0)
      break;


    sem_wait(&rw_sem); // Lock to 1 writer only
    //Enter Critical Section

    printf("Writer-tid: %d, is writing...\n", tid);
    //writing (chopping the last character of the string)
    size = strlen(str);
    str[size-1] = '\0';

    //Exit Critical Section
    sem_post(&rw_sem); // Unlock


    sleep(1);
    fflush(stdout); // clear the buffer
    printf("Writer-tid: %d, is exiting...\n", tid);

    pthread_exit(0);// exit thread

  }while(true);


  pthread_exit(NULL); // ensure all writer threads exit
}


/*Read Process is responsible for reading/outputting the
  string when appropriate*/
void *readProcess(void *param){

  //local variables
  long tid;
  tid = (long)param; // holds thread id


  do{
    //If string is empty leave loop
    if(strlen(str) == 0)
      break;


    sem_wait(&mutex); // Protect ReadCount
    // Enter critical section

    rc++; //add reader to ReadCount
    printf("ReadCount Increments to %d\n", rc);

    // No writer can enter if at least one reader
    if (rc == 1)
      sem_wait(&rw_sem);// signal writers to wait

    // Exit critical section
    sem_post(&mutex);


    //Reading performed
    printf("Reader-tid: %d, is Reading... Message: %s\n", tid, str);


    sem_wait(&mutex); // Reader wants to leave
    // Enter critical section

    rc--;  //remove reader from ReadCount
    printf("ReadCount Decrements to %d\n", rc);

    // If no reader left
    if (rc == 0)
      sem_post(&rw_sem); // Writers can enter

    // Exit critical section
    sem_post(&mutex); // Reader leaves


    fflush(stdout); // clear the buffer
    sleep(1);
    printf("Reader-tid: %d, is exiting...\n", tid);

    pthread_exit(0); // thread exits
  }while(true);


  pthread_exit(NULL); // Ensure all Read threads have exited
}


int main(int argc, char *argv[])
{
//Get command line args.
  int readTs = atoi(argv[1]), wrtTs = atoi(argv[2]), tc;
  pthread_t read[readTs], wrt[wrtTs]; // arrays of all the threads
  pthread_attr_t attr;

  // Check for correct amount of args
  if (argc != 3){
    perror("Need Two Args!\n");
    return -1;
  }

//Initialization of semaphores.
  if(sem_init(&rw_sem, 0, 1)){ // Wrt Lock
    perror("Failed to create rw_sem.\n");
    exit(-1);
  }
  if(sem_init(&mutex, 0, 1)){ // MUTEX
    perror("Failed to create mutex.\n");
    exit(-1);
  }


//Create reader and writer threads.
  pthread_attr_init(&attr);// default attributes

  //Create Reader threads
  for (long t = 0; t < readTs; t++){
    tc = pthread_create(&read[t], &attr, readProcess, (void *)t);

    if (tc){
      perror("ERROR creating READ thread.\n");
      exit(-1);
    }
  }
  //Create Writer threads
  for (long t = 0; t < wrtTs; t++){
    tc = pthread_create(&wrt[t], &attr, wrtProcess, (void *)t);

    if (tc){
      perror("ERROR creating WRITE thread.\n");
      exit(-1);
    }
  }


//Wait for reader threads to finish.
  for(long t = 0; t < readTs; t++){
    if(pthread_join(read[t], NULL)){ //join threads
      perror("Join Failed!\n");
      exit(-1);
    }
  }
//Wait for writer threads to finish.
  for(long t = 0; t < wrtTs; t++){
    if(pthread_join(wrt[t], NULL)){ //join threads
      perror("Join Failed!\n");
      exit(-1);
    }
  }


//Cleanup and exit.
  sem_destroy(&mutex);
  sem_destroy(&rw_sem);

  printf("All Threads Done.\n");
  pthread_exit(NULL); // Esure all threads have exited

  return 0;
}
