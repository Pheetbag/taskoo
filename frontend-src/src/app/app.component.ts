import { Component, OnInit } from '@angular/core';
import axios from 'axios';
import TaskInterface from '../TaskInterface';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent implements OnInit {
  title = 'frontend-src';

  tasks: Array<TaskInterface> = [];

  addTask(task: TaskInterface): void {
    this.tasks.unshift(task);
  }

  removeTask(task: TaskInterface): void {
    const index = this.tasks.indexOf(task);
    this.tasks.splice(index, 1);
  }

  async ngOnInit(): Promise<void> {
    const tasks = await axios.get('/api/tasks/');
    this.tasks = tasks.data;
  }
}
