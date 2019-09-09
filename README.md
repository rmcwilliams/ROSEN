# ROSEN
## Rensselaer Open Source Exams & Notes
ROSEN is a web application that allows students at RPI to have free access to course note, back exams, study guides, and more. 

## Style Guidelines
Our developers pride ourselves on writing beautiful and efficient code. Contributors should follow standard good style practices such as useful commenting, proper indentation, and portability.

## Code of Conduct
When making a new feature or a bug fix, please make a new branch from Master or the branch you're trying to modify. 
```git checkout **(original branch name)** ```
```git branch [new branch name] ```
```git checkout [new branch name]```

Branch names should be concise and self-explanatory. Please make your branch names lowercase and use hyphens (-) for spaces. You don't need to prepend your branch name with or include other details such as your name. For example, a feature branch for updating the about page UI might be called about-styles or about-page-ui.

When you have changes to your local code base in your new branch, commit push them with

```git commit -m [Commit message] ```
```git push```

Commit messages should be concise and self-explanatory, just like branch names.

Once your have completed your feature or fixed you bug, please perform a Pull Request into master, even if you are an admin. Pull requests provide a more readable commit log, highlighting major features and changes. On the Github repository website, click new pull request and select "master" <- "your branch name". This requires an admin to approve your changes before they are live on the develop branch.

